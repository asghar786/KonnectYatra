<?php

namespace Tests\Feature;

use App\Models\QuickYatri;
use App\Models\User;
use App\Support\YatriList;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * The Yatri List (2026-11-02): an order the office drags into shape, a tick per
 * yatri, and PDF / Excel downloads that carry the ticked yatris only.
 *
 * DatabaseTransactions: these run against the real local database, and both the
 * rows and the `qy_yatri_list` setting written here must not outlive the run.
 */
class QuickYatriListTest extends TestCase
{
    use DatabaseTransactions;

    private function asAdmin()
    {
        // In-memory only, never persisted — see QuickYatriSheetTest.
        $this->actingAs(new User(['role' => 'admin']));
    }

    private function yatri(string $name, array $attributes = []): QuickYatri
    {
        return QuickYatri::create(array_merge([
            'applicant_name' => $name,
            'citizenship'    => 'US',
            'passport_no'    => 'A' . random_int(10000000, 99999999),
        ], $attributes));
    }

    /** The posted rows, in the given order, with the given yatris ticked. */
    private function rowsFor(array $order, array $on): array
    {
        return array_map(function (QuickYatri $y) use ($on) {
            return in_array($y->id, array_map(function ($o) { return $o->id; }, $on), true)
                ? ['id' => $y->id, 'on' => 1]
                : ['id' => $y->id];
        }, $order);
    }

    public function test_the_page_lists_every_application_ticked_before_the_first_save()
    {
        $this->asAdmin();
        $a = $this->yatri('QA LIST ALPHA');

        $this->get(route('quick-yatri-list'))
            ->assertOk()
            ->assertSee('QA LIST ALPHA')
            ->assertSee(YatriList::DEFAULT_TITLE);

        $row = collect(YatriList::load()['rows'])->first(function ($r) use ($a) {
            return $r['yatri']->id === $a->id;
        });
        $this->assertTrue($row['on']);
    }

    public function test_saving_keeps_the_dragged_order_and_the_ticks()
    {
        $this->asAdmin();
        $a = $this->yatri('QA LIST ALPHA');
        $b = $this->yatri('QA LIST BRAVO');
        $c = $this->yatri('QA LIST CHARLIE');

        $this->post(route('quick-yatri-list-save'), [
            'title' => 'QA TITLE',
            'rows'  => $this->rowsFor([$c, $a, $b], [$c, $b]),
        ])->assertRedirect(route('quick-yatri-list'));

        $list  = YatriList::load();
        $mine  = array_values(array_filter($list['rows'], function ($r) use ($a, $b, $c) {
            return in_array($r['yatri']->id, [$a->id, $b->id, $c->id], true);
        }));
        $this->assertSame([$c->id, $a->id, $b->id], array_map(function ($r) { return $r['yatri']->id; }, $mine));
        $this->assertSame([true, false, true], array_column($mine, 'on'));
        $this->assertSame('QA TITLE', $list['title']);
    }

    public function test_an_application_added_after_a_save_joins_at_the_foot_ticked_and_marked_new()
    {
        $this->asAdmin();
        $a = $this->yatri('QA LIST ALPHA');
        $this->post(route('quick-yatri-list-save'), ['rows' => [['id' => $a->id, 'on' => 1]]]);

        $late = $this->yatri('QA LIST LATE');
        $last = collect(YatriList::load()['rows'])->last();

        $this->assertSame($late->id, $last['yatri']->id);
        $this->assertTrue($last['on']);
        $this->assertTrue($last['new']);
    }

    public function test_the_default_title_is_not_stored()
    {
        $this->asAdmin();
        $this->post(route('quick-yatri-list-save'), ['title' => strtolower(YatriList::DEFAULT_TITLE), 'rows' => []]);

        $this->assertSame('', YatriList::stored()['title']);
        $this->assertSame(YatriList::DEFAULT_TITLE, YatriList::load()['title']);
    }

    public function test_the_excel_file_holds_only_the_ticked_yatris_in_order()
    {
        $this->asAdmin();
        $a = $this->yatri('QA LIST ALPHA', ['passport_no' => '012345678']);
        $b = $this->yatri('QA LIST BRAVO');
        $c = $this->yatri('QA LIST CHARLIE', ['citizenship' => 'INDIAN']);

        // Everyone else in the real table is left unticked.
        $others = QuickYatri::whereNotIn('id', [$a->id, $b->id, $c->id])->get()->map(function ($y) {
            return ['id' => $y->id];
        })->all();

        $response = $this->post(route('quick-yatri-list-save'), [
            'rows' => array_merge($this->rowsFor([$c, $b, $a], [$c, $a]), $others),
            'then' => 'xlsx',
        ]);
        $response->assertOk();
        $this->assertStringContainsString('Yatri List.xlsx', $response->headers->get('content-disposition'));

        $zip = new \ZipArchive();
        $this->assertTrue($zip->open($response->getFile()->getPathname()));
        $sheet = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        $this->assertStringNotContainsString('QA LIST BRAVO', $sheet);
        $this->assertLessThan(strpos($sheet, 'QA LIST ALPHA'), strpos($sheet, 'QA LIST CHARLIE'));
        $this->assertStringContainsString('>Indian<', $sheet);
        $this->assertStringContainsString('>American<', $sheet);
        // Kept as text, so the leading zero survives.
        $this->assertStringContainsString('>012345678<', $sheet);
        $this->assertSame(1, substr_count($sheet, '<c r="A8" s="3"><v>2</v></c>'));
    }

    public function test_the_pdf_downloads_and_nothing_downloads_with_no_one_ticked()
    {
        $this->asAdmin();
        $a = $this->yatri('QA LIST ALPHA');

        $this->post(route('quick-yatri-list-save'), ['rows' => [['id' => $a->id, 'on' => 1]], 'then' => 'pdf'])
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');

        $none = QuickYatri::pluck('id')->map(function ($id) { return ['id' => $id]; })->all();
        $this->post(route('quick-yatri-list-save'), ['rows' => $none, 'then' => 'pdf'])
            ->assertRedirect(route('quick-yatri-list'))
            ->assertSessionHas('error');
    }

    public function test_nationality_reads_as_the_office_writes_it()
    {
        $this->assertSame('American', YatriList::nationality('US'));
        $this->assertSame('American', YatriList::nationality('american'));
        $this->assertSame('Indian', YatriList::nationality('INDIAN'));
        $this->assertSame('Kenyan', YatriList::nationality('KENYAN'));
    }
}
