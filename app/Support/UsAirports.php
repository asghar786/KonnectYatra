<?php

namespace App\Support;

/**
 * Every US airport with scheduled commercial passenger service, plus the
 * territories, as a static reference list.
 *
 * This is deliberately NOT the departure_origins table. That table is the short
 * admin-curated list of airports KonnectYatra actually sells departures from,
 * and it drives the public packages selector — pouring 400 airports into it
 * would wreck that page. The Quick Yatri sheet asks a different question
 * ("where is this applicant travelling from?"), which any US airport can
 * answer, so it reads this list instead. Nothing to seed or migrate: it ships
 * with the code and works on production the moment it deploys.
 *
 * Shape: state name => [ IATA code => [city, airport name] ].
 */
class UsAirports
{
    /** @var array|null code => [city, name, state, abbr], built once per request. */
    private static $flat = null;

    public static function grouped()
    {
        return [
            'Alabama' => [
                'BHM' => ['Birmingham', 'Birmingham–Shuttlesworth Intl'],
                'HSV' => ['Huntsville', 'Huntsville Intl'],
                'MOB' => ['Mobile', 'Mobile Regional'],
                'BFM' => ['Mobile', 'Mobile Downtown'],
                'MGM' => ['Montgomery', 'Montgomery Regional'],
                'DHN' => ['Dothan', 'Dothan Regional'],
                'MSL' => ['Muscle Shoals', 'Northwest Alabama Regional'],
            ],
            'Alaska' => [
                'ANC' => ['Anchorage', 'Ted Stevens Anchorage Intl'],
                'FAI' => ['Fairbanks', 'Fairbanks Intl'],
                'JNU' => ['Juneau', 'Juneau Intl'],
                'KTN' => ['Ketchikan', 'Ketchikan Intl'],
                'SIT' => ['Sitka', 'Sitka Rocky Gutierrez'],
                'BET' => ['Bethel', 'Bethel'],
                'OTZ' => ['Kotzebue', 'Ralph Wien Memorial'],
                'OME' => ['Nome', 'Nome'],
                'BRW' => ['Utqiagvik', 'Wiley Post–Will Rogers Memorial'],
                'SCC' => ['Deadhorse', 'Deadhorse'],
                'ADQ' => ['Kodiak', 'Kodiak'],
                'AKN' => ['King Salmon', 'King Salmon'],
                'DLG' => ['Dillingham', 'Dillingham'],
                'ENA' => ['Kenai', 'Kenai Municipal'],
                'HOM' => ['Homer', 'Homer'],
                'VDZ' => ['Valdez', 'Valdez'],
                'CDV' => ['Cordova', 'Merle K. Mudhole Smith'],
                'YAK' => ['Yakutat', 'Yakutat'],
                'PSG' => ['Petersburg', 'Petersburg James A. Johnson'],
                'WRG' => ['Wrangell', 'Wrangell'],
                'GST' => ['Gustavus', 'Gustavus'],
                'UNK' => ['Unalakleet', 'Unalakleet'],
                'DUT' => ['Unalaska', 'Unalaska/Dutch Harbor'],
                'CDB' => ['Cold Bay', 'Cold Bay'],
                'SDP' => ['Sand Point', 'Sand Point'],
            ],
            'Arizona' => [
                'PHX' => ['Phoenix', 'Phoenix Sky Harbor Intl'],
                'AZA' => ['Mesa', 'Phoenix–Mesa Gateway'],
                'TUS' => ['Tucson', 'Tucson Intl'],
                'FLG' => ['Flagstaff', 'Flagstaff Pulliam'],
                'YUM' => ['Yuma', 'Yuma Intl'],
                'PRC' => ['Prescott', 'Prescott Regional'],
                'GCN' => ['Grand Canyon', 'Grand Canyon National Park'],
                'PGA' => ['Page', 'Page Municipal'],
                'IFP' => ['Bullhead City', 'Laughlin/Bullhead Intl'],
                'SOW' => ['Show Low', 'Show Low Regional'],
            ],
            'Arkansas' => [
                'XNA' => ['Bentonville', 'Northwest Arkansas National'],
                'LIT' => ['Little Rock', 'Bill and Hillary Clinton National'],
                'FSM' => ['Fort Smith', 'Fort Smith Regional'],
                'TXK' => ['Texarkana', 'Texarkana Regional'],
                'HRO' => ['Harrison', 'Boone County'],
                'ELD' => ['El Dorado', 'South Arkansas Regional'],
                'JBR' => ['Jonesboro', 'Jonesboro Municipal'],
            ],
            'California' => [
                'LAX' => ['Los Angeles', 'Los Angeles Intl'],
                'SFO' => ['San Francisco', 'San Francisco Intl'],
                'SAN' => ['San Diego', 'San Diego Intl'],
                'SJC' => ['San Jose', 'Norman Y. Mineta San José Intl'],
                'OAK' => ['Oakland', 'San Francisco Bay Oakland Intl'],
                'SMF' => ['Sacramento', 'Sacramento Intl'],
                'SNA' => ['Santa Ana', 'John Wayne (Orange County)'],
                'ONT' => ['Ontario', 'Ontario Intl'],
                'BUR' => ['Burbank', 'Hollywood Burbank'],
                'LGB' => ['Long Beach', 'Long Beach'],
                'PSP' => ['Palm Springs', 'Palm Springs Intl'],
                'FAT' => ['Fresno', 'Fresno Yosemite Intl'],
                'SBA' => ['Santa Barbara', 'Santa Barbara Municipal'],
                'MRY' => ['Monterey', 'Monterey Regional'],
                'SBP' => ['San Luis Obispo', 'San Luis Obispo County'],
                'BFL' => ['Bakersfield', 'Meadows Field'],
                'STS' => ['Santa Rosa', 'Charles M. Schulz–Sonoma County'],
                'RDD' => ['Redding', 'Redding Regional'],
                'ACV' => ['Arcata/Eureka', 'California Redwood Coast–Humboldt County'],
                'SMX' => ['Santa Maria', 'Santa Maria Public'],
                'CLD' => ['Carlsbad', 'McClellan–Palomar'],
                'SCK' => ['Stockton', 'Stockton Metropolitan'],
                'MCE' => ['Merced', 'Merced Regional'],
                'VIS' => ['Visalia', 'Visalia Municipal'],
                'IPL' => ['El Centro', 'Imperial County'],
                'CEC' => ['Crescent City', 'Del Norte County'],
                'MMH' => ['Mammoth Lakes', 'Mammoth Yosemite'],
                'OXR' => ['Oxnard', 'Oxnard'],
            ],
            'Colorado' => [
                'DEN' => ['Denver', 'Denver Intl'],
                'COS' => ['Colorado Springs', 'Colorado Springs'],
                'ASE' => ['Aspen', 'Aspen/Pitkin County'],
                'EGE' => ['Vail/Eagle', 'Eagle County Regional'],
                'GJT' => ['Grand Junction', 'Grand Junction Regional'],
                'DRO' => ['Durango', 'Durango–La Plata County'],
                'HDN' => ['Steamboat Springs', 'Yampa Valley'],
                'MTJ' => ['Montrose', 'Montrose Regional'],
                'GUC' => ['Gunnison', 'Gunnison–Crested Butte Regional'],
                'PUB' => ['Pueblo', 'Pueblo Memorial'],
                'ALS' => ['Alamosa', 'San Luis Valley Regional'],
                'CEZ' => ['Cortez', 'Cortez Municipal'],
            ],
            'Connecticut' => [
                'BDL' => ['Hartford', 'Bradley Intl'],
                'HVN' => ['New Haven', 'Tweed New Haven'],
                'GON' => ['Groton', 'Groton–New London'],
            ],
            'Delaware' => [
                'ILG' => ['Wilmington', 'Wilmington/New Castle'],
            ],
            'District of Columbia' => [
                'DCA' => ['Washington', 'Ronald Reagan Washington National'],
            ],
            'Florida' => [
                'MIA' => ['Miami', 'Miami Intl'],
                'MCO' => ['Orlando', 'Orlando Intl'],
                'FLL' => ['Fort Lauderdale', 'Fort Lauderdale–Hollywood Intl'],
                'TPA' => ['Tampa', 'Tampa Intl'],
                'JAX' => ['Jacksonville', 'Jacksonville Intl'],
                'RSW' => ['Fort Myers', 'Southwest Florida Intl'],
                'PBI' => ['West Palm Beach', 'Palm Beach Intl'],
                'SFB' => ['Sanford', 'Orlando Sanford Intl'],
                'PIE' => ['St. Petersburg', 'St. Pete–Clearwater Intl'],
                'PNS' => ['Pensacola', 'Pensacola Intl'],
                'VPS' => ['Fort Walton Beach', 'Destin–Fort Walton Beach'],
                'ECP' => ['Panama City', 'Northwest Florida Beaches Intl'],
                'SRQ' => ['Sarasota', 'Sarasota–Bradenton Intl'],
                'TLH' => ['Tallahassee', 'Tallahassee Intl'],
                'DAB' => ['Daytona Beach', 'Daytona Beach Intl'],
                'GNV' => ['Gainesville', 'Gainesville Regional'],
                'MLB' => ['Melbourne', 'Melbourne Orlando Intl'],
                'EYW' => ['Key West', 'Key West Intl'],
                'PGD' => ['Punta Gorda', 'Punta Gorda'],
                'APF' => ['Naples', 'Naples Municipal'],
                'OCF' => ['Ocala', 'Ocala Intl'],
                'SGJ' => ['St. Augustine', 'Northeast Florida Regional'],
                'LAL' => ['Lakeland', 'Lakeland Linder Intl'],
                'VRB' => ['Vero Beach', 'Vero Beach Regional'],
                'MTH' => ['Marathon', 'Florida Keys Marathon Intl'],
            ],
            'Georgia' => [
                'ATL' => ['Atlanta', 'Hartsfield–Jackson Atlanta Intl'],
                'SAV' => ['Savannah', 'Savannah/Hilton Head Intl'],
                'AGS' => ['Augusta', 'Augusta Regional'],
                'CSG' => ['Columbus', 'Columbus'],
                'MCN' => ['Macon', 'Middle Georgia Regional'],
                'ABY' => ['Albany', 'Southwest Georgia Regional'],
                'VLD' => ['Valdosta', 'Valdosta Regional'],
                'BQK' => ['Brunswick', 'Brunswick Golden Isles'],
                'AHN' => ['Athens', 'Athens Ben Epps'],
            ],
            'Hawaii' => [
                'HNL' => ['Honolulu', 'Daniel K. Inouye Intl'],
                'OGG' => ['Kahului, Maui', 'Kahului'],
                'KOA' => ['Kailua-Kona', 'Ellison Onizuka Kona Intl'],
                'LIH' => ['Lihue, Kauai', 'Lihue'],
                'ITO' => ['Hilo', 'Hilo Intl'],
                'MKK' => ['Molokai', 'Molokai'],
                'LNY' => ['Lanai City', 'Lanai'],
                'JHM' => ['Kapalua, Maui', 'Kapalua'],
                'HNM' => ['Hana, Maui', 'Hana'],
            ],
            'Idaho' => [
                'BOI' => ['Boise', 'Boise Air Terminal'],
                'IDA' => ['Idaho Falls', 'Idaho Falls Regional'],
                'SUN' => ['Hailey/Sun Valley', 'Friedman Memorial'],
                'PIH' => ['Pocatello', 'Pocatello Regional'],
                'LWS' => ['Lewiston', 'Lewiston–Nez Perce County'],
                'TWF' => ['Twin Falls', 'Magic Valley Regional'],
            ],
            'Illinois' => [
                'ORD' => ['Chicago', "Chicago O'Hare Intl"],
                'MDW' => ['Chicago', 'Chicago Midway Intl'],
                'RFD' => ['Rockford', 'Chicago Rockford Intl'],
                'PIA' => ['Peoria', 'General Downing–Peoria Intl'],
                'MLI' => ['Moline', 'Quad Cities Intl'],
                'BMI' => ['Bloomington', 'Central Illinois Regional'],
                'SPI' => ['Springfield', 'Abraham Lincoln Capital'],
                'CMI' => ['Champaign', 'University of Illinois Willard'],
                'MWA' => ['Marion', 'Veterans Airport of Southern Illinois'],
                'DEC' => ['Decatur', 'Decatur'],
                'UIN' => ['Quincy', 'Quincy Regional'],
            ],
            'Indiana' => [
                'IND' => ['Indianapolis', 'Indianapolis Intl'],
                'FWA' => ['Fort Wayne', 'Fort Wayne Intl'],
                'SBN' => ['South Bend', 'South Bend Intl'],
                'EVV' => ['Evansville', 'Evansville Regional'],
            ],
            'Iowa' => [
                'DSM' => ['Des Moines', 'Des Moines Intl'],
                'CID' => ['Cedar Rapids', 'Eastern Iowa'],
                'ALO' => ['Waterloo', 'Waterloo Regional'],
                'SUX' => ['Sioux City', 'Sioux Gateway'],
                'DBQ' => ['Dubuque', 'Dubuque Regional'],
                'BRL' => ['Burlington', 'Southeast Iowa Regional'],
                'FOD' => ['Fort Dodge', 'Fort Dodge Regional'],
                'MCW' => ['Mason City', 'Mason City Municipal'],
            ],
            'Kansas' => [
                'ICT' => ['Wichita', 'Wichita Dwight D. Eisenhower National'],
                'MHK' => ['Manhattan', 'Manhattan Regional'],
                'GCK' => ['Garden City', 'Garden City Regional'],
                'HYS' => ['Hays', 'Hays Regional'],
                'SLN' => ['Salina', 'Salina Regional'],
                'LBL' => ['Liberal', 'Liberal Mid-America'],
                'DDC' => ['Dodge City', 'Dodge City Regional'],
                'TOP' => ['Topeka', 'Topeka Regional'],
            ],
            'Kentucky' => [
                'SDF' => ['Louisville', 'Louisville Muhammad Ali Intl'],
                'CVG' => ['Covington', 'Cincinnati/Northern Kentucky Intl'],
                'LEX' => ['Lexington', 'Blue Grass'],
                'PAH' => ['Paducah', 'Barkley Regional'],
                'OWB' => ['Owensboro', 'Owensboro–Daviess County'],
            ],
            'Louisiana' => [
                'MSY' => ['New Orleans', 'Louis Armstrong New Orleans Intl'],
                'BTR' => ['Baton Rouge', 'Baton Rouge Metropolitan'],
                'SHV' => ['Shreveport', 'Shreveport Regional'],
                'LFT' => ['Lafayette', 'Lafayette Regional'],
                'AEX' => ['Alexandria', 'Alexandria Intl'],
                'MLU' => ['Monroe', 'Monroe Regional'],
                'LCH' => ['Lake Charles', 'Lake Charles Regional'],
            ],
            'Maine' => [
                'PWM' => ['Portland', 'Portland Intl Jetport'],
                'BGR' => ['Bangor', 'Bangor Intl'],
                'PQI' => ['Presque Isle', 'Presque Isle Intl'],
                'RKD' => ['Rockland', 'Knox County Regional'],
                'BHB' => ['Bar Harbor', 'Hancock County–Bar Harbor'],
                'AUG' => ['Augusta', 'Augusta State'],
            ],
            'Maryland' => [
                'BWI' => ['Baltimore', 'Baltimore/Washington Intl Thurgood Marshall'],
                'SBY' => ['Salisbury', 'Salisbury–Ocean City Wicomico Regional'],
                'HGR' => ['Hagerstown', 'Hagerstown Regional'],
            ],
            'Massachusetts' => [
                'BOS' => ['Boston', 'Boston Logan Intl'],
                'ORH' => ['Worcester', 'Worcester Regional'],
                'ACK' => ['Nantucket', 'Nantucket Memorial'],
                'MVY' => ["Martha's Vineyard", "Martha's Vineyard"],
                'HYA' => ['Hyannis', 'Cape Cod Gateway'],
                'PVC' => ['Provincetown', 'Provincetown Municipal'],
            ],
            'Michigan' => [
                'DTW' => ['Detroit', 'Detroit Metropolitan Wayne County'],
                'GRR' => ['Grand Rapids', 'Gerald R. Ford Intl'],
                'FNT' => ['Flint', 'Bishop Intl'],
                'LAN' => ['Lansing', 'Capital Region Intl'],
                'AZO' => ['Kalamazoo', 'Kalamazoo/Battle Creek Intl'],
                'MBS' => ['Saginaw', 'MBS Intl'],
                'TVC' => ['Traverse City', 'Cherry Capital'],
                'MQT' => ['Marquette', 'Sawyer Intl'],
                'CIU' => ['Sault Ste. Marie', 'Chippewa County Intl'],
                'ESC' => ['Escanaba', 'Delta County'],
                'PLN' => ['Pellston', 'Pellston Regional'],
                'APN' => ['Alpena', 'Alpena County Regional'],
                'IMT' => ['Iron Mountain', 'Ford'],
                'CMX' => ['Hancock', 'Houghton County Memorial'],
                'MKG' => ['Muskegon', 'Muskegon County'],
            ],
            'Minnesota' => [
                'MSP' => ['Minneapolis', 'Minneapolis–St. Paul Intl'],
                'DLH' => ['Duluth', 'Duluth Intl'],
                'RST' => ['Rochester', 'Rochester Intl'],
                'BJI' => ['Bemidji', 'Bemidji Regional'],
                'BRD' => ['Brainerd', 'Brainerd Lakes Regional'],
                'HIB' => ['Hibbing', 'Range Regional'],
                'INL' => ['International Falls', 'Falls Intl'],
                'STC' => ['St. Cloud', 'St. Cloud Regional'],
                'TVF' => ['Thief River Falls', 'Thief River Falls Regional'],
            ],
            'Mississippi' => [
                'JAN' => ['Jackson', 'Jackson–Medgar Wiley Evers Intl'],
                'GPT' => ['Gulfport', 'Gulfport–Biloxi Intl'],
                'TUP' => ['Tupelo', 'Tupelo Regional'],
                'MEI' => ['Meridian', 'Meridian Regional'],
                'GTR' => ['Columbus', 'Golden Triangle Regional'],
                'GLH' => ['Greenville', 'Mid Delta Regional'],
                'PIB' => ['Laurel/Hattiesburg', 'Hattiesburg–Laurel Regional'],
            ],
            'Missouri' => [
                'STL' => ['St. Louis', 'St. Louis Lambert Intl'],
                'MCI' => ['Kansas City', 'Kansas City Intl'],
                'SGF' => ['Springfield', 'Springfield–Branson National'],
                'COU' => ['Columbia', 'Columbia Regional'],
                'JLN' => ['Joplin', 'Joplin Regional'],
                'CGI' => ['Cape Girardeau', 'Cape Girardeau Regional'],
                'IRK' => ['Kirksville', 'Kirksville Regional'],
                'TBN' => ['Fort Leonard Wood', 'Waynesville–St. Robert Regional'],
            ],
            'Montana' => [
                'BZN' => ['Bozeman', 'Bozeman Yellowstone Intl'],
                'BIL' => ['Billings', 'Billings Logan Intl'],
                'MSO' => ['Missoula', 'Missoula Montana'],
                'GTF' => ['Great Falls', 'Great Falls Intl'],
                'FCA' => ['Kalispell', 'Glacier Park Intl'],
                'HLN' => ['Helena', 'Helena Regional'],
                'BTM' => ['Butte', 'Bert Mooney'],
                'WYS' => ['West Yellowstone', 'Yellowstone'],
                'SDY' => ['Sidney', 'Sidney–Richland Regional'],
                'GGW' => ['Glasgow', 'Wokal Field'],
                'HVR' => ['Havre', 'Havre City–County'],
                'OLF' => ['Wolf Point', 'L. M. Clayton'],
                'MLS' => ['Miles City', 'Frank Wiley Field'],
            ],
            'Nebraska' => [
                'OMA' => ['Omaha', 'Eppley Airfield'],
                'LNK' => ['Lincoln', 'Lincoln'],
                'GRI' => ['Grand Island', 'Central Nebraska Regional'],
                'BFF' => ['Scottsbluff', 'Western Nebraska Regional'],
                'LBF' => ['North Platte', 'North Platte Regional'],
                'EAR' => ['Kearney', 'Kearney Regional'],
                'CDR' => ['Chadron', 'Chadron Municipal'],
                'MCK' => ['McCook', 'McCook Ben Nelson Regional'],
            ],
            'Nevada' => [
                'LAS' => ['Las Vegas', 'Harry Reid Intl'],
                'RNO' => ['Reno', 'Reno–Tahoe Intl'],
                'EKO' => ['Elko', 'Elko Regional'],
            ],
            'New Hampshire' => [
                'MHT' => ['Manchester', 'Manchester–Boston Regional'],
                'PSM' => ['Portsmouth', 'Portsmouth Intl at Pease'],
                'LEB' => ['Lebanon', 'Lebanon Municipal'],
            ],
            'New Jersey' => [
                'EWR' => ['Newark', 'Newark Liberty Intl'],
                'ACY' => ['Atlantic City', 'Atlantic City Intl'],
                'TTN' => ['Trenton', 'Trenton–Mercer'],
            ],
            'New Mexico' => [
                'ABQ' => ['Albuquerque', 'Albuquerque Intl Sunport'],
                'SAF' => ['Santa Fe', 'Santa Fe Regional'],
                'ROW' => ['Roswell', 'Roswell Air Center'],
                'FMN' => ['Farmington', 'Four Corners Regional'],
                'HOB' => ['Hobbs', 'Lea County Regional'],
                'CNM' => ['Carlsbad', 'Cavern City Air Terminal'],
                'ALM' => ['Alamogordo', 'Alamogordo–White Sands Regional'],
                'SVC' => ['Silver City', 'Grant County'],
                'LRU' => ['Las Cruces', 'Las Cruces Intl'],
            ],
            'New York' => [
                'JFK' => ['New York', 'John F. Kennedy Intl'],
                'LGA' => ['New York', 'LaGuardia'],
                'ISP' => ['Islip', 'Long Island MacArthur'],
                'SWF' => ['Newburgh', 'New York Stewart Intl'],
                'HPN' => ['White Plains', 'Westchester County'],
                'BUF' => ['Buffalo', 'Buffalo Niagara Intl'],
                'ROC' => ['Rochester', 'Frederick Douglass Greater Rochester Intl'],
                'SYR' => ['Syracuse', 'Syracuse Hancock Intl'],
                'ALB' => ['Albany', 'Albany Intl'],
                'ITH' => ['Ithaca', 'Ithaca Tompkins Intl'],
                'ELM' => ['Elmira', 'Elmira Corning Regional'],
                'BGM' => ['Binghamton', 'Greater Binghamton'],
                'PBG' => ['Plattsburgh', 'Plattsburgh Intl'],
                'ART' => ['Watertown', 'Watertown Intl'],
                'IAG' => ['Niagara Falls', 'Niagara Falls Intl'],
                'OGS' => ['Ogdensburg', 'Ogdensburg Intl'],
                'MSS' => ['Massena', 'Massena Intl'],
                'SLK' => ['Saranac Lake', 'Adirondack Regional'],
                'JHW' => ['Jamestown', 'Chautauqua County'],
            ],
            'North Carolina' => [
                'CLT' => ['Charlotte', 'Charlotte Douglas Intl'],
                'RDU' => ['Raleigh/Durham', 'Raleigh–Durham Intl'],
                'GSO' => ['Greensboro', 'Piedmont Triad Intl'],
                'AVL' => ['Asheville', 'Asheville Regional'],
                'ILM' => ['Wilmington', 'Wilmington Intl'],
                'FAY' => ['Fayetteville', 'Fayetteville Regional'],
                'OAJ' => ['Jacksonville', 'Albert J. Ellis'],
                'EWN' => ['New Bern', 'Coastal Carolina Regional'],
                'PGV' => ['Greenville', 'Pitt–Greenville'],
                'INT' => ['Winston-Salem', 'Smith Reynolds'],
                'HKY' => ['Hickory', 'Hickory Regional'],
            ],
            'North Dakota' => [
                'FAR' => ['Fargo', 'Hector Intl'],
                'BIS' => ['Bismarck', 'Bismarck Municipal'],
                'GFK' => ['Grand Forks', 'Grand Forks Intl'],
                'MOT' => ['Minot', 'Minot Intl'],
                'ISN' => ['Williston', 'Williston Basin Intl'],
                'DIK' => ['Dickinson', 'Dickinson Theodore Roosevelt Regional'],
                'JMS' => ['Jamestown', 'Jamestown Regional'],
                'DVL' => ['Devils Lake', 'Devils Lake Regional'],
            ],
            'Ohio' => [
                'CLE' => ['Cleveland', 'Cleveland Hopkins Intl'],
                'CMH' => ['Columbus', 'John Glenn Columbus Intl'],
                'DAY' => ['Dayton', 'Dayton Intl'],
                'CAK' => ['Akron/Canton', 'Akron–Canton'],
                'TOL' => ['Toledo', 'Eugene F. Kranz Toledo Express'],
                'YNG' => ['Youngstown', 'Youngstown–Warren Regional'],
                'LCK' => ['Columbus', 'Rickenbacker Intl'],
            ],
            'Oklahoma' => [
                'OKC' => ['Oklahoma City', 'Will Rogers World'],
                'TUL' => ['Tulsa', 'Tulsa Intl'],
                'LAW' => ['Lawton', 'Lawton–Fort Sill Regional'],
                'SWO' => ['Stillwater', 'Stillwater Regional'],
            ],
            'Oregon' => [
                'PDX' => ['Portland', 'Portland Intl'],
                'EUG' => ['Eugene', 'Mahlon Sweet Field'],
                'MFR' => ['Medford', 'Rogue Valley Intl–Medford'],
                'RDM' => ['Redmond/Bend', 'Roberts Field'],
                'OTH' => ['North Bend', 'Southwest Oregon Regional'],
                'LMT' => ['Klamath Falls', 'Klamath Falls'],
                'PDT' => ['Pendleton', 'Eastern Oregon Regional'],
            ],
            'Pennsylvania' => [
                'PHL' => ['Philadelphia', 'Philadelphia Intl'],
                'PIT' => ['Pittsburgh', 'Pittsburgh Intl'],
                'MDT' => ['Harrisburg', 'Harrisburg Intl'],
                'ABE' => ['Allentown', 'Lehigh Valley Intl'],
                'AVP' => ['Wilkes-Barre/Scranton', 'Wilkes-Barre/Scranton Intl'],
                'ERI' => ['Erie', 'Erie Intl'],
                'LBE' => ['Latrobe', 'Arnold Palmer Regional'],
                'IPT' => ['Williamsport', 'Williamsport Regional'],
                'JST' => ['Johnstown', 'Johnstown–Cambria County'],
                'BFD' => ['Bradford', 'Bradford Regional'],
                'DUJ' => ['DuBois', 'DuBois Regional'],
                'LNS' => ['Lancaster', 'Lancaster'],
                'UNV' => ['State College', 'University Park'],
            ],
            'Rhode Island' => [
                'PVD' => ['Providence', 'Rhode Island T. F. Green Intl'],
                'BID' => ['Block Island', 'Block Island State'],
                'WST' => ['Westerly', 'Westerly State'],
            ],
            'South Carolina' => [
                'CHS' => ['Charleston', 'Charleston Intl'],
                'GSP' => ['Greenville/Spartanburg', 'Greenville–Spartanburg Intl'],
                'CAE' => ['Columbia', 'Columbia Metropolitan'],
                'MYR' => ['Myrtle Beach', 'Myrtle Beach Intl'],
                'HHH' => ['Hilton Head Island', 'Hilton Head'],
                'FLO' => ['Florence', 'Florence Regional'],
            ],
            'South Dakota' => [
                'FSD' => ['Sioux Falls', 'Joe Foss Field'],
                'RAP' => ['Rapid City', 'Rapid City Regional'],
                'ABR' => ['Aberdeen', 'Aberdeen Regional'],
                'PIR' => ['Pierre', 'Pierre Regional'],
                'ATY' => ['Watertown', 'Watertown Regional'],
            ],
            'Tennessee' => [
                'BNA' => ['Nashville', 'Nashville Intl'],
                'MEM' => ['Memphis', 'Memphis Intl'],
                'TYS' => ['Knoxville', 'McGhee Tyson'],
                'CHA' => ['Chattanooga', 'Chattanooga Metropolitan'],
                'TRI' => ['Bristol/Johnson City/Kingsport', 'Tri-Cities'],
                'MKL' => ['Jackson', 'McKellar–Sipes Regional'],
            ],
            'Texas' => [
                'DFW' => ['Dallas/Fort Worth', 'Dallas/Fort Worth Intl'],
                'IAH' => ['Houston', 'George Bush Intercontinental'],
                'DAL' => ['Dallas', 'Dallas Love Field'],
                'HOU' => ['Houston', 'William P. Hobby'],
                'AUS' => ['Austin', 'Austin–Bergstrom Intl'],
                'SAT' => ['San Antonio', 'San Antonio Intl'],
                'ELP' => ['El Paso', 'El Paso Intl'],
                'MAF' => ['Midland/Odessa', 'Midland Intl Air & Space'],
                'LBB' => ['Lubbock', 'Lubbock Preston Smith Intl'],
                'AMA' => ['Amarillo', 'Rick Husband Amarillo Intl'],
                'CRP' => ['Corpus Christi', 'Corpus Christi Intl'],
                'HRL' => ['Harlingen', 'Valley Intl'],
                'MFE' => ['McAllen', 'McAllen Intl'],
                'BRO' => ['Brownsville', 'Brownsville/South Padre Island Intl'],
                'GRK' => ['Killeen', 'Killeen–Fort Cavazos Regional'],
                'ACT' => ['Waco', 'Waco Regional'],
                'TYR' => ['Tyler', 'Tyler Pounds Regional'],
                'SJT' => ['San Angelo', 'San Angelo Regional'],
                'ABI' => ['Abilene', 'Abilene Regional'],
                'CLL' => ['College Station', 'Easterwood'],
                'LRD' => ['Laredo', 'Laredo Intl'],
                'BPT' => ['Beaumont/Port Arthur', 'Jack Brooks Regional'],
                'SPS' => ['Wichita Falls', 'Wichita Falls Regional'],
                'VCT' => ['Victoria', 'Victoria Regional'],
                'DRT' => ['Del Rio', 'Del Rio Intl'],
                'GGG' => ['Longview', 'East Texas Regional'],
            ],
            'Utah' => [
                'SLC' => ['Salt Lake City', 'Salt Lake City Intl'],
                'SGU' => ['St. George', 'St. George Regional'],
                'PVU' => ['Provo', 'Provo Municipal'],
                'OGD' => ['Ogden', 'Ogden–Hinckley'],
                'CNY' => ['Moab', 'Canyonlands Field'],
                'CDC' => ['Cedar City', 'Cedar City Regional'],
                'VEL' => ['Vernal', 'Vernal Regional'],
            ],
            'Vermont' => [
                'BTV' => ['Burlington', 'Burlington Intl'],
                'RUT' => ['Rutland', 'Rutland Southern Vermont Regional'],
            ],
            'Virginia' => [
                'IAD' => ['Washington Dulles', 'Washington Dulles Intl'],
                'ORF' => ['Norfolk', 'Norfolk Intl'],
                'RIC' => ['Richmond', 'Richmond Intl'],
                'ROA' => ['Roanoke', 'Roanoke–Blacksburg Regional'],
                'CHO' => ['Charlottesville', 'Charlottesville–Albemarle'],
                'PHF' => ['Newport News', 'Newport News/Williamsburg Intl'],
                'LYH' => ['Lynchburg', 'Lynchburg Regional'],
                'SHD' => ['Staunton', 'Shenandoah Valley Regional'],
            ],
            'Washington' => [
                'SEA' => ['Seattle/Tacoma', 'Seattle–Tacoma Intl'],
                'GEG' => ['Spokane', 'Spokane Intl'],
                'PAE' => ['Everett', 'Seattle Paine Field Intl'],
                'PSC' => ['Pasco', 'Tri-Cities'],
                'BLI' => ['Bellingham', 'Bellingham Intl'],
                'YKM' => ['Yakima', 'Yakima Air Terminal'],
                'EAT' => ['Wenatchee', 'Pangborn Memorial'],
                'ALW' => ['Walla Walla', 'Walla Walla Regional'],
                'PUW' => ['Pullman', 'Pullman–Moscow Regional'],
                'CLM' => ['Port Angeles', 'William R. Fairchild Intl'],
                'FRD' => ['Friday Harbor', 'Friday Harbor'],
            ],
            'West Virginia' => [
                'CRW' => ['Charleston', 'Yeager'],
                'HTS' => ['Huntington', 'Tri-State'],
                'CKB' => ['Clarksburg', 'North Central West Virginia'],
                'MGW' => ['Morgantown', 'Morgantown Municipal'],
                'LWB' => ['Lewisburg', 'Greenbrier Valley'],
                'BKW' => ['Beckley', 'Raleigh County Memorial'],
                'PKB' => ['Parkersburg', 'Mid-Ohio Valley Regional'],
            ],
            'Wisconsin' => [
                'MKE' => ['Milwaukee', 'Milwaukee Mitchell Intl'],
                'MSN' => ['Madison', 'Dane County Regional'],
                'GRB' => ['Green Bay', 'Austin Straubel Intl'],
                'ATW' => ['Appleton', 'Appleton Intl'],
                'CWA' => ['Mosinee', 'Central Wisconsin'],
                'LSE' => ['La Crosse', 'La Crosse Regional'],
                'EAU' => ['Eau Claire', 'Chippewa Valley Regional'],
                'RHI' => ['Rhinelander', 'Rhinelander–Oneida County'],
            ],
            'Wyoming' => [
                'JAC' => ['Jackson', 'Jackson Hole'],
                'CPR' => ['Casper', 'Casper–Natrona County Intl'],
                'CYS' => ['Cheyenne', 'Cheyenne Regional'],
                'COD' => ['Cody', 'Yellowstone Regional'],
                'GCC' => ['Gillette', 'Gillette–Campbell County'],
                'RIW' => ['Riverton', 'Riverton Regional'],
                'RKS' => ['Rock Springs', 'Rock Springs–Sweetwater County'],
                'SHR' => ['Sheridan', 'Sheridan County'],
                'LAR' => ['Laramie', 'Laramie Regional'],
                'WRL' => ['Worland', 'Worland Municipal'],
            ],
            'Puerto Rico' => [
                'SJU' => ['San Juan', 'Luis Muñoz Marín Intl'],
                'BQN' => ['Aguadilla', 'Rafael Hernández Intl'],
                'PSE' => ['Ponce', 'Mercedita Intl'],
                'MAZ' => ['Mayagüez', 'Eugenio María de Hostos'],
                'VQS' => ['Vieques', 'Antonio Rivera Rodríguez'],
                'CPX' => ['Culebra', 'Benjamín Rivera Noriega'],
            ],
            'U.S. Virgin Islands' => [
                'STT' => ['St. Thomas', 'Cyril E. King'],
                'STX' => ['St. Croix', 'Henry E. Rohlsen'],
            ],
            'Guam' => [
                'GUM' => ['Tamuning', 'Antonio B. Won Pat Intl'],
            ],
            'American Samoa' => [
                'PPG' => ['Pago Pago', 'Pago Pago Intl'],
            ],
            'Northern Mariana Islands' => [
                'SPN' => ['Saipan', 'Saipan Intl'],
                'ROP' => ['Rota', 'Rota Intl'],
            ],
        ];
    }

    /** State name => two-letter abbreviation, for the compact "PHL/PA" form. */
    public static function abbreviations()
    {
        return [
            'Alabama' => 'AL', 'Alaska' => 'AK', 'Arizona' => 'AZ', 'Arkansas' => 'AR',
            'California' => 'CA', 'Colorado' => 'CO', 'Connecticut' => 'CT', 'Delaware' => 'DE',
            'District of Columbia' => 'DC', 'Florida' => 'FL', 'Georgia' => 'GA', 'Hawaii' => 'HI',
            'Idaho' => 'ID', 'Illinois' => 'IL', 'Indiana' => 'IN', 'Iowa' => 'IA',
            'Kansas' => 'KS', 'Kentucky' => 'KY', 'Louisiana' => 'LA', 'Maine' => 'ME',
            'Maryland' => 'MD', 'Massachusetts' => 'MA', 'Michigan' => 'MI', 'Minnesota' => 'MN',
            'Mississippi' => 'MS', 'Missouri' => 'MO', 'Montana' => 'MT', 'Nebraska' => 'NE',
            'Nevada' => 'NV', 'New Hampshire' => 'NH', 'New Jersey' => 'NJ', 'New Mexico' => 'NM',
            'New York' => 'NY', 'North Carolina' => 'NC', 'North Dakota' => 'ND', 'Ohio' => 'OH',
            'Oklahoma' => 'OK', 'Oregon' => 'OR', 'Pennsylvania' => 'PA', 'Rhode Island' => 'RI',
            'South Carolina' => 'SC', 'South Dakota' => 'SD', 'Tennessee' => 'TN', 'Texas' => 'TX',
            'Utah' => 'UT', 'Vermont' => 'VT', 'Virginia' => 'VA', 'Washington' => 'WA',
            'West Virginia' => 'WV', 'Wisconsin' => 'WI', 'Wyoming' => 'WY',
            'Puerto Rico' => 'PR', 'U.S. Virgin Islands' => 'VI', 'Guam' => 'GU',
            'American Samoa' => 'AS', 'Northern Mariana Islands' => 'MP',
        ];
    }

    /** code => ['city' => .., 'name' => .., 'state' => .., 'abbr' => ..] */
    public static function flat()
    {
        if (self::$flat === null) {
            $abbr = self::abbreviations();
            $flat = [];
            foreach (self::grouped() as $state => $airports) {
                foreach ($airports as $code => $pair) {
                    $flat[$code] = [
                        'city'  => $pair[0],
                        'name'  => $pair[1],
                        'state' => $state,
                        'abbr'  => isset($abbr[$state]) ? $abbr[$state] : '',
                    ];
                }
            }
            self::$flat = $flat;
        }

        return self::$flat;
    }

    public static function has($code)
    {
        $code = strtoupper(trim((string) $code));
        $flat = self::flat();

        return $code !== '' && isset($flat[$code]);
    }

    /** "PHL — Philadelphia, PA" — the dropdown option and the printed value. */
    public static function label($code)
    {
        $code = strtoupper(trim((string) $code));
        $flat = self::flat();
        if (!isset($flat[$code])) {
            return $code;
        }
        $a = $flat[$code];

        return $code . ' — ' . $a['city'] . ($a['abbr'] !== '' ? ', ' . $a['abbr'] : '');
    }

    /** "PHL/PA" — the tight form, for the pre-filled blank sheet. */
    public static function shortLabel($code)
    {
        $code = strtoupper(trim((string) $code));
        $flat = self::flat();
        if (!isset($flat[$code])) {
            return $code;
        }

        return $code . ($flat[$code]['abbr'] !== '' ? '/' . $flat[$code]['abbr'] : '');
    }
}
