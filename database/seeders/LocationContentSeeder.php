<?php

namespace Database\Seeders;

use App\Models\Locations;
use Illuminate\Database\Seeder;

/**
 * Real content for the 17 places on the yatra itinerary.
 *
 * Every `locations.description` was empty, so each /location-detail page rendered
 * 42–62 words of template chrome and nothing else — unrankable, and useless to a
 * pilgrim deciding whether the trip covers what they came for. These pages are
 * where the sharpest keywords land (Nankana Sahib Yatra, Panja Sahib Yatra,
 * Gurdwara Dera Sahib Lahore Tour), so they earn real writing.
 *
 * Idempotent and non-destructive: a location that already has a description is
 * skipped, so re-running never overwrites what an admin has since edited. Pass
 * --force-overwrite via ARGV only if you genuinely mean to replace them.
 *
 * Historical and religious detail follows the mainstream accounts and is written
 * so that traditional narratives are attributed as such. It should still be read
 * by Rashad before it goes in front of pilgrims.
 */
class LocationContentSeeder extends Seeder
{
    /**
     * Corrections to data that is wrong in the table, applied by location id.
     *
     * Nankana Sahib was recorded as being in Lahore. It is its own city and
     * district roughly 80 km away, and the error was published in the page
     * title of a shrine that is the single most important site on the tour.
     */
    private const CITY_FIXES = [
        3 => 'Nankana Sahib',
    ];

    /**
     * Names that reach the public page title, and were wrong there.
     *
     * 5  carried a trailing ", Lahore." inside the name itself, so the title
     *    read "Badshahi Mosque, Lahore. | Konnect Yatra".
     * 15 held two non-breaking spaces (U+00A0) mid-name and spelled Singhnian
     *    "Sighnian".
     * 17 spelled Maharaja "Mahraja".
     */
    private const NAME_FIXES = [
        5  => 'Badshahi Mosque',
        15 => 'Gurdwara Sahib Shaheed Ganj Singh Singhnian',
        17 => 'Haveli of Maharaja Ranjit Singh',
    ];

    /** Keyed by location name exactly as stored. */
    private function content(): array
    {
        return [

            'Gurdwara Panja Sahib' => <<<TXT
            Gurdwara Panja Sahib at Hasan Abdal is one of the most revered Sikh shrines in Pakistan, and for most yatris it is the first major stop after arriving in Islamabad.

            The shrine takes its name from the panja — the open handprint that Sikh tradition holds was left by Guru Nanak on a boulder here. Guru Nanak is said to have reached Hasan Abdal with Bhai Mardana in the summer of 1521, during the travels known as the udasis. In the account passed down through the sangat, a spring rose at the Guru's touch and the rock that was sent down towards him came to rest against his open palm, leaving the impression that pilgrims come to see today.

            The boulder sits at the edge of a large sarovar fed by that spring, stocked with fish and enclosed by the white marble of the gurdwara complex. Pilgrims take a dip in the sarovar, pay respects at the panja itself, and sit for langar in the dining hall alongside sangat who have travelled from across the world.

            Panja Sahib fills at Vaisakhi, when jathas arrive from India and the diaspora and the complex stays awake through the night with kirtan. It is quieter outside those weeks, and many yatris prefer it that way — there is time to sit by the water without moving on.

            Hasan Abdal is about 50 km north-west of Islamabad on the Grand Trunk Road, so the visit is usually made as a day trip from the group's Islamabad or Rawalpindi hotel. Konnect Yatra groups travel together by coach with our own transport and security throughout.
            TXT,

            'Nankana Sahib' => <<<TXT
            Nankana Sahib is the birthplace of Guru Nanak, and the reason most yatris make this journey at all.

            Guru Nanak was born here in 1469, in the village then called Rai Bhoi Di Talwandi. The town that grew around the site now carries his name. Gurdwara Janam Asthan stands on the spot where tradition places his birth, and it is the largest and most visited of the shrines in the town — a broad white complex with a gold-domed sanctum, wide courtyards and a sarovar, able to hold the tens of thousands who arrive for Gurpurab.

            Nankana Sahib is not one shrine but a cluster of them, each tied to an episode from the Guru's early life: Gurdwara Bal Lila, associated with his childhood; Gurdwara Patti Sahib, where he is said to have confounded his teacher; Gurdwara Kiara Sahib, remembered for the field left untouched while the buffaloes grazed; Gurdwara Mal Ji Sahib and Gurdwara Tambu Sahib. Yatra groups usually walk between several of them in a single visit.

            The town is at its fullest in November for Guru Nanak's birth anniversary, when the main jatha arrives from India across the Wagah border and the sangat swells into the tens of thousands. Nagar kirtan moves through the streets, and langar runs continuously.

            Nankana Sahib is around 80 km south-west of Lahore, and Konnect Yatra groups reach it by coach from their Lahore hotel. Our team travels with the group, and the visit is arranged so there is time to sit in the darbar rather than only pass through.
            TXT,

            'Kartarpur Sahib' => <<<TXT
            Gurdwara Darbar Sahib at Kartarpur is where Guru Nanak settled at the end of his travels, and where he spent the last years of his life.

            After the udasis, the Guru put down his staff here on the bank of the Ravi, farmed the land, and gathered the community that formed around the daily discipline of naam japna, kirat karni and vand chhakna — meditating on the Name, earning an honest living, and sharing what you earn. The institutions that shaped Sikhi as a way of living, langar and sangat among them, took their working shape in this settlement. Guru Nanak passed away at Kartarpur in 1539, having named Bhai Lehna as Guru Angad, his successor.

            The gurdwara is a white complex set among fields, restored and considerably expanded in recent years, with a large sarovar, a langar hall and wide open ground around the darbar. The Indian border runs only a few kilometres away, and the Kartarpur Corridor now allows pilgrims from India to cross for the day — which means the sangat here is often a mix of yatris who arrived by very different routes.

            For many yatris Kartarpur is the quietest and most affecting stop on the itinerary. It is a working landscape rather than a city shrine, and something of the settlement the Guru actually built is still legible in it.

            Kartarpur is in Narowal district, reached by road from Lahore. Konnect Yatra groups travel there together with our own transport and staff.
            TXT,

            'Gurdwara Dera Sahib' => <<<TXT
            Gurdwara Dera Sahib in Lahore marks the martyrdom of Guru Arjan Dev, the fifth Guru, in 1606.

            Guru Arjan Dev compiled the Adi Granth, the scripture that became the Guru Granth Sahib, and completed the Harmandir Sahib at Amritsar. In 1606 he was summoned to Lahore and imprisoned in the fort. The Sikh account holds that he was required to pay an enormous fine and to remove passages from the newly compiled scripture that the Mughal court objected to; he refused both, and was tortured and put to death. He passed away in the waters of the Ravi, which then ran beside this spot.

            The gurdwara was raised over the site in 1619 by his son, Guru Hargobind, and was later enlarged under Maharaja Ranjit Singh, who added the gilded dome that still marks it out on the Lahore skyline.

            Its setting says a great deal on its own. Dera Sahib stands directly opposite Lahore Fort, where the Guru was held, and immediately beside the Samadhi of Maharaja Ranjit Singh, with the Badshahi Mosque a short walk away. Three centuries of Punjab's history sit within a few hundred metres, and yatra groups usually take them together.

            The martyrdom anniversary each summer draws Sikh pilgrims from India and the diaspora, and the darbar is busy through the day. Konnect Yatra groups visit Dera Sahib as part of the Lahore programme, travelling together with our own transport and staff.
            TXT,

            'Gurdwara Rohri Sahib' => <<<TXT
            Gurdwara Rohri Sahib at Eminabad, in Gujranwala district, is tied to Guru Nanak's presence in the town and to one of the most pointed episodes recorded of him.

            Tradition holds that the Guru stayed here on a bed of pebbles — rohri in Punjabi, which gives the shrine its name — and that he was at Eminabad when Babur's army sacked the town. The verses in which Guru Nanak describes that devastation, and calls its rulers to account for what befell ordinary people, are among the most unflinching passages in the Guru Granth Sahib. Sikhs know them as the Babur-vani. For yatris who have read them, standing at Eminabad gives those verses a place.

            Eminabad also holds Gurdwara Chakki Sahib, associated with the hand-mill the Guru is said to have been set to work at while held by Babur's men, and Gurdwara Khooi Bhai Lalo, connected with Bhai Lalo, the carpenter whose plain food the Guru chose over a nobleman's feast — the sakhi in which honest labour is set above wealth.

            The shrines are modest compared with Nankana Sahib or Panja Sahib, and the visit is usually shorter. That is part of their character: these are working-town sites tied to a strand of Guru Nanak's teaching about power and honest earning.

            Eminabad lies south of Gujranwala, on the road between Lahore and the north. Konnect Yatra groups stop here as part of the wider itinerary, travelling with our own transport and staff.
            TXT,

            'Gurdwara Sacha Sauda Sahib' => <<<TXT
            Gurdwara Sacha Sauda at Farooqabad, in Sheikhupura district, marks the sakhi of the true bargain — the story most often told to explain what Guru Nanak meant by a life well spent.

            The account holds that Guru Nanak's father gave him twenty rupees and sent him to trade, expecting him to return with goods and a profit. On the road, travelling with Bhai Mardana, the young Nanak came upon a group of holy men who had gone without food. He spent the whole sum feeding them and came home with nothing. Asked to account for it, he said he had made the true bargain — sacha sauda. The place where he is said to have fed them is where this gurdwara now stands.

            It is the origin story Sikhs point to for langar, and for vand chhakna, the principle of sharing what you earn. That a nine-hundred-rupee institution now feeds anyone who walks in, anywhere in the world, without asking who they are, traces back to this roadside.

            The gurdwara itself is a white domed complex with a sarovar and a langar hall, set in what is still largely farmland. Farooqabad was formerly called Chuharkana; the town changed name, the shrine did not.

            Sacha Sauda is usually visited on the road between Lahore and Nankana Sahib, which makes it a natural stop on the same day. Konnect Yatra groups travel together with our own transport and staff.
            TXT,

            'Gurdwara Janamastan Guru Ram Das Ji' => <<<TXT
            This gurdwara in Lahore marks the birthplace of Guru Ram Das, the fourth Guru, born in the city in 1534.

            Guru Ram Das is remembered above all as the founder of the city of Amritsar, and for beginning the excavation of the sarovar around which the Harmandir Sahib was later built by his son, Guru Arjan Dev. He composed the Lavan, the four verses recited at an Anand Karaj, which means that his words are present at every Sikh wedding.

            He was born in the old walled city, into a family of modest means, and orphaned young. The shrine stands in the Chuna Mandi area, within the dense lanes of inner Lahore rather than on an open site, so reaching it means walking through the old city — which many yatris find is part of the visit rather than an obstacle to it.

            It is a smaller and quieter shrine than Dera Sahib, and easily missed on a short itinerary. For pilgrims who want to understand how much of early Sikh history happened inside Lahore itself, it is worth the detour: the fourth Guru was born here, the fifth was martyred here, and the city held both.

            Konnect Yatra groups visit as part of the Lahore programme where the schedule allows, travelling together with our own transport and staff.
            TXT,

            'Gurudwara Sahib Bebe Nanki Ji' => <<<TXT
            This shrine near Lahore honours Bebe Nanki, the elder sister of Guru Nanak, and the first person to recognise what her brother was.

            Sikh tradition is unambiguous on this point: before there was a sangat, before the udasis, before anyone else understood, Bebe Nanki knew. She supported her brother when their father did not, and she is remembered as the first Sikh — the first to accept Guru Nanak's teaching. It was she who gave him the rabab that Bhai Mardana played, the instrument that carried the first kirtan.

            Her married home was at Sultanpur Lodhi, and it was there that Guru Nanak worked at the modikhana and, according to the accounts, entered the river Bein and emerged after three days to begin his mission. The sites around Lahore associated with her family are visited by yatris who want to give her place in the story its due.

            Shrines connected to Bebe Nanki are quieter and less visited than the major gurdwaras, and the schedule for them varies by itinerary and by what access permits at the time. If this site matters to you, tell us before you travel and we will tell you honestly whether your group's programme reaches it.

            Konnect Yatra groups travel together with our own transport and staff throughout the Lahore programme.
            TXT,

            'Gurdwara Sahib Shaheed Ganj Singh Singhnian' => <<<TXT
            Gurdwara Shaheed Ganj in Lahore is a memorial to the Sikhs executed in the city during the eighteenth century, and it is not an easy place to visit.

            Shaheed ganj means a place of martyrs. Through the middle decades of the 1700s, Sikhs in Punjab were hunted under a policy of extermination, with prices set on their heads. Those captured were brought to Lahore and killed publicly at the horse market — the Nakhas — near this site. The period is remembered in Sikh history as the ghallugharas, and it is the ground from which the Ardas phrase honouring those who gave their heads but not their faith comes.

            The gurdwara commemorates the Singhs and Singhnians — the men and the women — who were put to death here. That the women are named in the shrine's own title is the point of it; their part in that period is not treated as a footnote.

            It is a plain site rather than a grand one, and most yatris come away subdued. Groups that have just come from Nankana Sahib, where the story begins in joy, often find the contrast is what stays with them.

            The gurdwara stands in inner Lahore. Konnect Yatra groups visit as part of the Lahore programme, travelling together with our own transport and staff.
            TXT,

            'Samadhi of Raja Ranjit Singh' => <<<TXT
            The Samadhi of Maharaja Ranjit Singh stands beside Gurdwara Dera Sahib in Lahore, at the foot of the fort, and marks the resting place of the ruler who made the Sikh Empire.

            Ranjit Singh took Lahore in 1799 and was proclaimed Maharaja in 1801, uniting the misls into a single state that eventually ran from the Khyber to the Sutlej. He was a Sikh sovereign who kept Muslim and Hindu ministers and generals, restored and gilded the Harmandir Sahib at Amritsar, and left the Badshahi Mosque standing a few hundred metres from his own court. He died in 1839; within a decade of his death the empire had been annexed.

            The samadhi was completed under his son, Kharak Singh, and is a striking building in its own right — fluted domes, gilded cupolas, and a fusion of Sikh, Mughal and Rajput detail that belongs to no single tradition. Inside, a marble urn holds his ashes.

            For yatris, its value is in where it sits. The samadhi, Dera Sahib, Lahore Fort and the Badshahi Mosque stand within sight of one another. Guru Arjan Dev was martyred here in 1606; two centuries later a Sikh ruler held the city and left the mosque untouched. Standing in that one spot is the clearest way to see the whole arc.

            Konnect Yatra groups visit as part of the Lahore programme, travelling together with our own transport and staff.
            TXT,

            'Samadhi of Bhai Mani Singh' => <<<TXT
            This memorial in Lahore honours Bhai Mani Singh, the scholar and martyr executed in the city in 1738.

            Bhai Mani Singh was a granthi of the Harmandir Sahib at Amritsar and one of the most learned Sikhs of his generation, entrusted with the scripture and with the affairs of the sangat at a time when both were under severe pressure. He sought permission from the Lahore administration to hold a Diwali gathering at Amritsar, on payment of a tax. When the gathering did not take place as agreed — the accounts hold that troops were sent to attack it — the tax was demanded regardless. He could not pay, and refused to accept Islam as the alternative offered.

            He was sentenced to be dismembered joint by joint. Sikh tradition records that when the executioner began at the wrist rather than the finger joints, Bhai Mani Singh corrected him, and held to the sentence as it had been passed.

            The site is a quiet one and is often visited together with Gurdwara Shaheed Ganj, since both belong to the same decades of persecution in Lahore. Yatris who come here tend to know the account already; those who do not are usually told it standing in front of the memorial.

            Konnect Yatra groups visit as part of the Lahore programme where the schedule allows, travelling together with our own transport and staff.
            TXT,

            'Darbar Sien Mian Mir Sahib' => <<<TXT
            The shrine of Mian Mir in Lahore is a Sufi darbar, and Sikhs visit it for a reason that goes to the heart of how the Gurus worked.

            Mian Mir was a Qadiri Sufi saint of Lahore, born in Sindh, who died in 1635. He and Guru Arjan Dev were close, and Sikh tradition holds that it was Mian Mir whom the fifth Guru asked to lay the foundation stone of the Harmandir Sahib at Amritsar in 1588 — a Muslim saint invited to lay the first stone of the holiest Sikh shrine, at the Guru's own request.

            That single act is why the site belongs on a Sikh itinerary. The Harmandir Sahib has doors on all four sides so that people may enter from any direction; asking Mian Mir to begin it made the same statement before a single wall went up. Accounts also record that he interceded, without success, when Guru Arjan Dev was imprisoned in Lahore in 1606.

            The darbar itself is a working Sufi shrine with a domed tomb chamber and courtyards, busy with its own devotees rather than arranged for visitors. Yatris are guests here and are asked to dress and behave accordingly.

            Konnect Yatra groups visit as part of the Lahore programme, travelling together with our own transport and staff.
            TXT,

            'Haveli of Maharaja Ranjit Singh' => <<<TXT
            The haveli associated with Maharaja Ranjit Singh at Gujranwala stands in the town where he was born in 1780.

            Gujranwala was the seat of the Sukerchakia misl, the confederacy his grandfather Charat Singh and father Mahan Singh led before him. Ranjit Singh inherited its leadership as a boy, having lost his father at around twelve and survived smallpox that cost him an eye. From this town he moved on Lahore in 1799 and took it before he was twenty.

            The haveli is a domestic building rather than a monument — the household of a misl chief, not the court of a Maharaja. Its condition reflects that: this is not a restored showpiece, and yatris should expect an old building in a working town.

            It is worth the stop for what it explains. The samadhi in Lahore shows the empire at its height, gilded and confident. Gujranwala shows where the man started, which was a good deal more modest, and makes the distance he covered legible.

            Gujranwala lies on the road north from Lahore, and the stop is usually combined with Eminabad and Gurdwara Rohri Sahib. Konnect Yatra groups travel together with our own transport and staff.
            TXT,

            'Lahore Fort' => <<<TXT
            Lahore Fort is a UNESCO World Heritage Site, and for Sikh yatris it carries a particular weight: this is where Guru Arjan Dev was imprisoned in 1606 before his martyrdom.

            The fort in its present form is largely Mughal, rebuilt in brick by Akbar in the 1560s and extended by Jahangir, Shah Jahan and Aurangzeb. Its best-known interiors belong to that period — the Sheesh Mahal with its mirrored ceiling, the Naulakha pavilion, and the vast tiled picture wall along the northern face. Aurangzeb's Alamgiri Gate opens towards the Badshahi Mosque.

            The Sikh period left its own layer. Ranjit Singh took the fort in 1799 and used it as his seat, and parts of it were altered under his rule. Gurdwara Dera Sahib and his samadhi stand immediately outside the walls.

            For a yatra group the fort is not a sightseeing detour bolted onto a pilgrimage. Standing inside it, with Dera Sahib visible beyond the gate, is how the events of 1606 stop being an account read in a book and become a distance you can see across.

            The fort, the Badshahi Mosque, Dera Sahib and the samadhi are adjacent and are normally taken as one visit. Konnect Yatra groups travel together with our own transport and staff.
            TXT,

            'Badshahi Mosque' => <<<TXT
            The Badshahi Mosque faces Lahore Fort across the Hazuri Bagh, and stands a few hundred metres from Gurdwara Dera Sahib.

            Built under Aurangzeb and completed in 1673, it was for centuries the largest mosque in the world, and it remains one of the largest. The red sandstone façade, the three marble domes and a courtyard that holds tens of thousands make it the defining image of Mughal Lahore.

            It appears on a Sikh itinerary because of what stands around it. When Ranjit Singh held Lahore, the mosque was within his power and it was left standing; his own samadhi and the gurdwara marking Guru Arjan Dev's martyrdom sit within sight of it. Sikh, Mughal and colonial Lahore occupy one square of ground here, and the mosque is one corner of it.

            Visitors remove shoes and cover their heads, and women should have a scarf; the courtyard stone gets extremely hot in summer, so early morning or late afternoon is easier. It is a working mosque, and yatris visit as guests.

            Konnect Yatra groups take the mosque together with the fort, Dera Sahib and the samadhi, travelling with our own transport and staff.
            TXT,

            'Minar-e-Pakistan' => <<<TXT
            Minar-e-Pakistan stands in Iqbal Park in Lahore, on the ground where the Lahore Resolution was passed in March 1940 — the demand that led to the creation of Pakistan in 1947.

            The tower was completed in the 1960s, around sixty metres tall, rising from a base of terraced platforms. Visitors can climb it, and the view takes in the old city, the fort and the Badshahi Mosque.

            For a Sikh yatra group its significance is less about the monument than about the year it commemorates. Partition in 1947 is why these shrines sit on the other side of a border from the community that reveres them, why a yatra needs a visa at all, and why the Kartarpur Corridor exists. Nankana Sahib, Panja Sahib, Kartarpur and Dera Sahib were not always places you needed permission to reach.

            Most groups stop briefly, usually alongside the fort and the Badshahi Mosque, which are close by. It is a short visit and an unsentimental one, and it puts the rest of the itinerary in its proper frame.

            Konnect Yatra groups travel together with our own transport and staff throughout the Lahore programme.
            TXT,

            'Faisal Masjid' => <<<TXT
            Faisal Mosque sits at the foot of the Margalla Hills in Islamabad and is usually the first stop on the itinerary, because most yatra groups land at Islamabad International and spend their first nights in the capital.

            Completed in 1986 and funded by Saudi Arabia, it was designed by the Turkish architect Vedat Dalokay and looks unlike any other major mosque: no dome at all, but a white concrete structure shaped like a desert tent, framed by four slender minarets. It was the largest mosque in the world for many years and still holds tens of thousands.

            For a Sikh group this is a stop for orientation rather than pilgrimage. It gives the first morning a fixed point, the hills behind it are a good introduction to the landscape, and it is a short drive from the hotels used in Islamabad and Rawalpindi.

            The natural pairing is with Gurdwara Panja Sahib at Hasan Abdal, about 50 km away on the Grand Trunk Road, which most itineraries take on the same day or the next.

            Visitors remove shoes and cover their heads, and it is quietest early in the day. Konnect Yatra groups travel together with our own transport and staff.
            TXT,
        ];
    }

    public function run(): void
    {
        $overwrite = in_array('--force-overwrite', $_SERVER['argv'] ?? [], true);
        $content   = $this->content();
        $written   = 0;
        $skipped   = 0;
        $missing   = [];

        foreach (self::NAME_FIXES as $id => $name) {
            $loc = Locations::find($id);
            if ($loc && $loc->name !== $name) {
                $this->command?->info("Correcting name for #{$id}: \"{$loc->name}\" → \"{$name}\"");
                $loc->name = $name;
                $loc->save();
            }
        }

        foreach (self::CITY_FIXES as $id => $city) {
            $loc = Locations::find($id);
            if ($loc && $loc->city !== $city) {
                $this->command?->info("Correcting city for #{$id} ({$loc->name}): {$loc->city} → {$city}");
                $loc->city = $city;
                $loc->save();
            }
        }

        // Match on a normalised name, not an exact one. Several rows were typed
        // or pasted with non-breaking spaces inside the name (U+00A0 after "Ganj"
        // and "Singh" in row 15), which look identical in the admin and never
        // match a literal. Load once and key by the normalised form.
        $byName = Locations::all()->keyBy(fn ($l) => $this->key($l->name));

        foreach ($content as $name => $text) {
            $loc = $byName->get($this->key($name));

            if (!$loc) {
                $missing[] = $name;
                continue;
            }

            if (!$overwrite && trim(strip_tags((string) $loc->description)) !== '') {
                $skipped++;
                continue;
            }

            // Stored as plain text: the view renders nl2br(e($description)),
            // so any markup would be escaped and shown to the reader.
            $loc->description = $this->normalise($text);
            $loc->save();
            $written++;
        }

        $this->command?->info("Location content: {$written} written, {$skipped} left alone (already had text).");

        foreach ($missing as $name) {
            $this->command?->warn("No location row named \"{$name}\" — skipped.");
        }
    }

    /**
     * A comparable form of a location name: non-breaking spaces folded to
     * ordinary ones, runs of whitespace collapsed, case ignored.
     */
    private function key(string $name): string
    {
        $name = str_replace(["\xc2\xa0", "\xe2\x80\x8b"], ' ', $name);

        return mb_strtolower(trim(preg_replace('/\s+/u', ' ', $name)));
    }

    /** Heredoc indentation out, paragraph breaks kept. */
    private function normalise(string $text): string
    {
        $lines = array_map('trim', explode("\n", trim($text)));

        return implode("\n\n", array_filter($lines, fn ($l) => $l !== ''));
    }
}
