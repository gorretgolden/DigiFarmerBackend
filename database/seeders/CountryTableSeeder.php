<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [
                'id'         => 1,
                'name'       => 'Afghanistan',
                'short_code' => 'af',
                'country_code'=> '+93'

            ],
            [
                'id'         => 2,
                'name'       => 'Albania',
                'short_code' => 'al',
                'country_code'=> '+355'
            ],
            [
                'id'         => 3,
                'name'       => 'Algeria',
                'short_code' => 'dz',
                'country_code'=> '+213'
            ],
            [
                'id'         => 4,
                'name'       => 'American Samoa',
                'short_code' => 'as',
                'country_code'=> '+1'

            ],
            [
                'id'         => 5,
                'name'       => 'Andorra',
                'short_code' => 'ad',
                'country_code'=> '+376'
            ],
            [
                'id'         => 6,
                'name'       => 'Angola',
                'short_code' => 'ao',
                'country_code'=> '+244'
            ],
            [
                'id'         => 7,
                'name'       => 'Anguilla',
                'short_code' => 'ai',
                'country_code'=> '+1'
            ],
            [
                'id'         => 8,
                'name'       => 'Antarctica',
                'short_code' => 'aq',
                'country_code'=> '+672'
            ],
            [
                'id'         => 9,
                'name'       => 'Antigua and Barbuda',
                'short_code' => 'ag',
                'country_code'=> '+1'
            ],
            [
                'id'         => 10,
                'name'       => 'Argentina',
                'short_code' => 'ar',
                'country_code'=> '+54'
            ],
            [
                'id'         => 11,
                'name'       => 'Armenia',
                'short_code' => 'am',
                'country_code'=> '+374'
            ],
            [
                'id'         => 12,
                'name'       => 'Aruba',
                'short_code' => 'aw',
                'country_code'=> '+297'
            ],
            [
                'id'         => 13,
                'name'       => 'Australia',
                'short_code' => 'au',
                'country_code'=> '+61'
            ],
            [
                'id'         => 14,
                'name'       => 'Austria',
                'short_code' => 'at',
                'country_code'=> '+43'
            ],
            [
                'id'         => 15,
                'name'       => 'Azerbaijan',
                'short_code' => 'az',
                'country_code'=> '+994'
            ],
            [
                'id'         => 16,
                'name'       => 'Bahamas',
                'short_code' => 'bs',
                'country_code'=> '+1'
            ],
            [
                'id'         => 17,
                'name'       => 'Bahrain',
                'short_code' => 'bh',
                'country_code'=> '+973'
            ],
            [
                'id'         => 18,
                'name'       => 'Bangladesh',
                'short_code' => 'bd',
                'country_code'=> '+880'
            ],
            [
                'id'         => 19,
                'name'       => 'Barbados',
                'short_code' => 'bb',
                'country_code'=> '+1'
            ],
            [
                'id'         => 20,
                'name'       => 'Belarus',
                'short_code' => 'by',
                'country_code'=> '+375'
            ],
            [
                'id'         => 21,
                'name'       => 'Belgium',
                'short_code' => 'be',
                'country_code'=> '+32'
            ],
            [
                'id'         => 22,
                'name'       => 'Belize',
                'short_code' => 'bz',
                'country_code'=> '+1',
                'country_code'=> '+501'
            ],
            [
                'id'         => 23,
                'name'       => 'Benin',
                'short_code' => 'bj',
                'country_code'=> '+229'
            ],
            [
                'id'         => 24,
                'name'       => 'Bermuda',
                'short_code' => 'bm',
                'country_code'=> '+1'
            ],
            [
                'id'         => 25,
                'name'       => 'Bhutan',
                'short_code' => 'bt',
                'country_code'=> '+975'
            ],
            [
                'id'         => 26,
                'name'       => 'Bolivia',
                'short_code' => 'bo',
                'country_code'=> '+591'
            ],
            [
                'id'         => 27,
                'name'       => 'Bosnia and Herzegovina',
                'short_code' => 'ba',
                'country_code'=> '+387'
            ],
            [
                'id'         => 28,
                'name'       => 'Botswana',
                'short_code' => 'bw',
                'country_code'=> '+267'
            ],
            [
                'id'         => 29,
                'name'       => 'Brazil',
                'short_code' => 'br',
                'country_code'=> '+55'
            ],
            [
                'id'         => 30,
                'name'       => 'British Indian Ocean Territory',
                'short_code' => 'io',
                'country_code'=> '+246'
            ],
            [
                'id'         => 31,
                'name'       => 'British Virgin Islands',
                'short_code' => 'vg',
                'country_code'=> '+1'
            ],
            [
                'id'         => 32,
                'name'       => 'Brunei',
                'short_code' => 'bn',
                'country_code'=> '+673'
            ],
            [
                'id'         => 33,
                'name'       => 'Bulgaria',
                'short_code' => 'bg',
                'country_code'=> '+359'
            ],
            [
                'id'         => 34,
                'name'       => 'Burkina Faso',
                'short_code' => 'bf',
                'country_code'=> '+226'
            ],
            [
                'id'         => 35,
                'name'       => 'Burundi',
                'short_code' => 'bi',
                'country_code'=> '+257'
            ],
            [
                'id'         => 36,
                'name'       => 'Cambodia',
                'short_code' => 'kh',
                'country_code'=> '+855'
            ],
            [
                'id'         => 37,
                'name'       => 'Cameroon',
                'short_code' => 'cm',
                'country_code'=> '+237'
            ],
            [
                'id'         => 38,
                'name'       => 'Canada',
                'short_code' => 'ca',
                'country_code'=> '+1'
            ],
            [
                'id'         => 39,
                'name'       => 'Cape Verde',
                'short_code' => 'cv',
                'country_code'=> '+238'
            ],
            [
                'id'         => 40,
                'name'       => 'Cayman Islands',
                'short_code' => 'ky',
                'country_code'=> '+1'
            ],
            [
                'id'         => 41,
                'name'       => 'Central African Republic',
                'short_code' => 'cf',
                'country_code'=> '+236'
            ],
            [
                'id'         => 42,
                'name'       => 'Chad',
                'short_code' => 'td',
                'country_code'=> '+235'
            ],
            [
                'id'         => 43,
                'name'       => 'Chile',
                'short_code' => 'cl',
                'country_code'=> '+56'
            ],
            [
                'id'         => 44,
                'name'       => 'China',
                'short_code' => 'cn',
                'country_code'=> '+86'
            ],
            [
                'id'         => 45,
                'name'       => 'Christmas Island',
                'short_code' => 'cx',
                'country_code'=> '+61'
            ],
            [
                'id'         => 46,
                'name'       => 'Cocos Islands',
                'short_code' => 'cc',
                'country_code'=> '+61'
            ],
            [
                'id'         => 47,
                'name'       => 'Colombia',
                'short_code' => 'co',
                'country_code'=> '+57'
            ],
            [
                'id'         => 48,
                'name'       => 'Comoros',
                'short_code' => 'km',
                'country_code'=> '+269'
            ],
            [
                'id'         => 49,
                'name'       => 'Cook Islands',
                'short_code' => 'ck',
                'country_code'=> '+682'
            ],
            [
                'id'         => 50,
                'name'       => 'Costa Rica',
                'short_code' => 'cr',
                'country_code'=> '+506'
            ],
            [
                'id'         => 51,
                'name'       => 'Croatia',
                'short_code' => 'hr',
                'country_code'=> '+385'
            ],
            [
                'id'         => 52,
                'name'       => 'Cuba',
                'short_code' => 'cu',
                'country_code'=> '+53'
            ],
            [
                'id'         => 53,
                'name'       => 'Curacao',
                'short_code' => 'cw',
                'country_code'=> '+599'
            ],
            [
                'id'         => 54,
                'name'       => 'Cyprus',
                'short_code' => 'cy',
                'country_code'=> '+357'
            ],
            [
                'id'         => 55,
                'name'       => 'Czech Republic',
                'short_code' => 'cz',
                'country_code'=> '+420'
            ],
            [
                'id'         => 56,
                'name'       => 'Democratic Republic of the Congo',
                'short_code' => 'cd',
                'country_code'=> '+243'
            ],
            [
                'id'         => 57,
                'name'       => 'Denmark',
                'short_code' => 'dk',
                'country_code'=> '+45'
            ],
            [
                'id'         => 58,
                'name'       => 'Djibouti',
                'short_code' => 'dj',
                'country_code'=> '+253'
            ],
            [
                'id'         => 59,
                'name'       => 'Dominica',
                'short_code' => 'dm',
                'country_code'=> '+1'
            ],
            [
                'id'         => 60,
                'name'       => 'Dominican Republic',
                'short_code' => 'do',
                'country_code'=> '+1'
            ],
            [
                'id'         => 61,
                'name'       => 'East Timor',
                'short_code' => 'tl',
                'country_code'=> '+670'
            ],
            [
                'id'         => 62,
                'name'       => 'Ecuador',
                'short_code' => 'ec',
                'country_code'=> '+593'
            ],
            [
                'id'         => 63,
                'name'       => 'Egypt',
                'short_code' => 'eg',
                'country_code'=> '+20'
            ],
            [
                'id'         => 64,
                'name'       => 'El Salvador',
                'short_code' => 'sv',
                'country_code'=> '+503'
            ],
            [
                'id'         => 65,
                'name'       => 'Equatorial Guinea',
                'short_code' => 'gq',
                'country_code'=> '+240'
            ],
            [
                'id'         => 66,
                'name'       => 'Eritrea',
                'short_code' => 'er',
                'country_code'=> '+291'
            ],
            [
                'id'         => 67,
                'name'       => 'Estonia',
                'short_code' => 'ee',
                'country_code'=> '+372'
            ],
            [
                'id'         => 68,
                'name'       => 'Ethiopia',
                'short_code' => 'et',
                'country_code'=> '+251'
            ],
            [
                'id'         => 69,
                'name'       => 'Falkland Islands',
                'short_code' => 'fk',
                'country_code'=> '+500'
            ],
            [
                'id'         => 70,
                'name'       => 'Faroe Islands',
                'short_code' => 'fo',
                'country_code'=> '+298'
            ],
            [
                'id'         => 71,
                'name'       => 'Fiji',
                'short_code' => 'fj',
                'country_code'=> '+679'
            ],
            [
                'id'         => 72,
                'name'       => 'Finland',
                'short_code' => 'fi',
                'country_code'=> '+358'
            ],
            [
                'id'         => 73,
                'name'       => 'France',
                'short_code' => 'fr',
                'country_code'=> '+33'
            ],
            [
                'id'         => 74,
                'name'       => 'French Polynesia',
                'short_code' => 'pf',
                'country_code'=> '+689'
            ],
            [
                'id'         => 75,
                'name'       => 'Gabon',
                'short_code' => 'ga',
                'country_code'=> '+241'
            ],
            [
                'id'         => 76,
                'name'       => 'Gambia',
                'short_code' => 'gm',
                'country_code'=> '+220'
            ],
            [
                'id'         => 77,
                'name'       => 'Georgia',
                'short_code' => 'ge',
                'country_code'=> '+995'
            ],
            [
                'id'         => 78,
                'name'       => 'Germany',
                'short_code' => 'de',
                'country_code'=> '+49'
            ],
            [
                'id'         => 79,
                'name'       => 'Ghana',
                'short_code' => 'gh',
                'country_code'=> '+233'
            ],
            [
                'id'         => 80,
                'name'       => 'Gibraltar',
                'short_code' => 'gi',
                'country_code'=> '+350'
            ],
            [
                'id'         => 81,
                'name'       => 'Greece',
                'short_code' => 'gr',
                'country_code'=> '+30'
            ],
            [
                'id'         => 82,
                'name'       => 'Greenland',
                'short_code' => 'gl',
                'country_code'=> '+299'
            ],
            [
                'id'         => 83,
                'name'       => 'Grenada',
                'short_code' => 'gd',
                'country_code'=> '+1'
            ],
            [
                'id'         => 84,
                'name'       => 'Guam',
                'short_code' => 'gu',
                'country_code'=> '+1'
            ],
            [
                'id'         => 85,
                'name'       => 'Guatemala',
                'short_code' => 'gt',
                'country_code'=> '+502'
            ],
            [
                'id'         => 86,
                'name'       => 'Guernsey',
                'short_code' => 'gg',
                'country_code'=> '+44-1481'
            ],
            [
                'id'         => 87,
                'name'       => 'Guinea',
                'short_code' => 'gn',
                'country_code'=> '+224'
            ],
            [
                'id'         => 88,
                'name'       => 'Guinea-Bissau',
                'short_code' => 'gw',
                'country_code'=> '+245'
            ],
            [
                'id'         => 89,
                'name'       => 'Guyana',
                'short_code' => 'gy',
                'country_code'=> '+592'
            ],
            [
                'id'         => 90,
                'name'       => 'Haiti',
                'short_code' => 'ht',
                'country_code'=> '+509'
            ],
            [
                'id'         => 91,
                'name'       => 'Honduras',
                'short_code' => 'hn',
                'country_code'=> '+504'
            ],
            [
                'id'         => 92,
                'name'       => 'Hong Kong',
                'short_code' => 'hk',
                'country_code'=> '+852'
            ],
            [
                'id'         => 93,
                'name'       => 'Hungary',
                'short_code' => 'hu',
                'country_code'=> '+36'
            ],
            [
                'id'         => 94,
                'name'       => 'Iceland',
                'short_code' => 'is',
                'country_code'=> '+354'
            ],
            [
                'id'         => 95,
                'name'       => 'India',
                'short_code' => 'in',
                'country_code'=> '+91'
            ],
            [
                'id'         => 96,
                'name'       => 'Indonesia',
                'short_code' => 'id',
                'country_code'=> '+62'
            ],
            [
                'id'         => 97,
                'name'       => 'Iran',
                'short_code' => 'ir',
                'country_code'=> '+98'
            ],
            [
                'id'         => 98,
                'name'       => 'Iraq',
                'short_code' => 'iq',
                'country_code'=> '+964'
            ],
            [
                'id'         => 99,
                'name'       => 'Ireland',
                'short_code' => 'ie',
                'country_code'=> '+353'
            ],
            [
                'id'         => 100,
                'name'       => 'Isle of Man',
                'short_code' => 'im',
                'country_code'=> '+44'
            ],
            [
                'id'         => 101,
                'name'       => 'Israel',
                'short_code' => 'il',
                'country_code'=> '+972'
            ],
            [
                'id'         => 102,
                'name'       => 'Italy',
                'short_code' => 'it',
                'country_code'=> '+39'
            ],
            [
                'id'         => 103,
                'name'       => 'Ivory Coast',
                'short_code' => 'ci',
                'country_code'=> '+225'
            ],
            [
                'id'         => 104,
                'name'       => 'Jamaica',
                'short_code' => 'jm',
                'country_code'=> '+1'
            ],
            [
                'id'         => 105,
                'name'       => 'Japan',
                'short_code' => 'jp',
                'country_code'=> '+81'
            ],
            [
                'id'         => 106,
                'name'       => 'Jersey',
                'short_code' => 'je',
                'country_code'=> '+44'
            ],
            [
                'id'         => 107,
                'name'       => 'Jordan',
                'short_code' => 'jo',
                'country_code'=> '+962'
            ],
            [
                'id'         => 108,
                'name'       => 'Kazakhstan',
                'short_code' => 'kz',
                'country_code'=> '+7'
            ],
            [
                'id'         => 109,
                'name'       => 'Kenya',
                'short_code' => 'ke',
                'country_code'=> '+254'

            ],
            [
                'id'         => 110,
                'name'       => 'Kiribati',
                'short_code' => 'ki',
                'country_code'=> '+686'
            ],
            [
                'id'         => 111,
                'name'       => 'Kosovo',
                'short_code' => 'xk',
                'country_code'=> '+383'
            ],
            [
                'id'         => 112,
                'name'       => 'Kuwait',
                'short_code' => 'kw',
                'country_code'=> '+965'
            ],
            [
                'id'         => 113,
                'name'       => 'Kyrgyzstan',
                'short_code' => 'kg',
                'country_code'=> '+996'
            ],
            [
                'id'         => 114,
                'name'       => 'Laos',
                'short_code' => 'la',
                'country_code'=> '+856'
            ],
            [
                'id'         => 115,
                'name'       => 'Latvia',
                'short_code' => 'lv',
                'country_code'=> '+371'
            ],
            [
                'id'         => 116,
                'name'       => 'Lebanon',
                'short_code' => 'lb',
                'country_code'=> '+961'
            ],
            [
                'id'         => 117,
                'name'       => 'Lesotho',
                'short_code' => 'ls',
                'country_code'=> '+266'
            ],
            [
                'id'         => 118,
                'name'       => 'Liberia',
                'short_code' => 'lr',
                'country_code'=> '+231'
            ],
            [
                'id'         => 119,
                'name'       => 'Libya',
                'short_code' => 'ly',
                'country_code'=> '+218'
            ],
            [
                'id'         => 120,
                'name'       => 'Liechtenstein',
                'short_code' => 'li',
                'country_code'=> '+423'
            ],
            [
                'id'         => 121,
                'name'       => 'Lithuania',
                'short_code' => 'lt',
                'country_code'=> '+370'
            ],
            [
                'id'         => 122,
                'name'       => 'Luxembourg',
                'short_code' => 'lu',
                'country_code'=> '+352'
            ],
            [
                'id'         => 123,
                'name'       => 'Macau',
                'short_code' => 'mo',
                'country_code'=> '+853'
            ],
            [
                'id'         => 124,
                'name'       => 'North Macedonia',
                'short_code' => 'mk',
                'country_code'=> '+389'
            ],
            [
                'id'         => 125,
                'name'       => 'Madagascar',
                'short_code' => 'mg',
                'country_code'=> '+261'
            ],
            [
                'id'         => 126,
                'name'       => 'Malawi',
                'short_code' => 'mw',
                'country_code'=> '+265'
            ],
            [
                'id'         => 127,
                'name'       => 'Malaysia',
                'short_code' => 'my',
                'country_code'=> '+60'
            ],
            [
                'id'         => 128,
                'name'       => 'Maldives',
                'short_code' => 'mv',
                'country_code'=> '+960'
            ],
            [
                'id'         => 129,
                'name'       => 'Mali',
                'short_code' => 'ml',
                'country_code'=> '+223'
            ],
            [
                'id'         => 130,
                'name'       => 'Malta',
                'short_code' => 'mt',
                'country_code'=> '+356'
            ],
            [
                'id'         => 131,
                'name'       => 'Marshall Islands',
                'short_code' => 'mh',
                'country_code'=> '+692'
            ],
            [
                'id'         => 132,
                'name'       => 'Mauritania',
                'short_code' => 'mr',
                'country_code'=> '+222'
            ],
            [
                'id'         => 133,
                'name'       => 'Mauritius',
                'short_code' => 'mu',
                'country_code'=> '+230'
            ],
            [
                'id'         => 134,
                'name'       => 'Mayotte',
                'short_code' => 'yt',
                'country_code'=> '+262'
            ],
            [
                'id'         => 135,
                'name'       => 'Mexico',
                'short_code' => 'mx',
                'country_code'=> '+52'
            ],
            [
                'id'         => 136,
                'name'       => 'Micronesia',
                'short_code' => 'fm',
                'country_code'=> '+691'
            ],
            [
                'id'         => 137,
                'name'       => 'Moldova',
                'short_code' => 'md',
                'country_code'=> '+373'
            ],
            [
                'id'         => 138,
                'name'       => 'Monaco',
                'short_code' => 'mc',
                'country_code'=> '+377'
            ],
            [
                'id'         => 139,
                'name'       => 'Mongolia',
                'short_code' => 'mn',
                'country_code'=> '+976'
            ],
            [
                'id'         => 140,
                'name'       => 'Montenegro',
                'short_code' => 'me',
                'country_code'=> '+382'
            ],
            [
                'id'         => 141,
                'name'       => 'Montserrat',
                'short_code' => 'ms',
                'country_code'=> '+1'
            ],
            [
                'id'         => 142,
                'name'       => 'Morocco',
                'short_code' => 'ma',
                'country_code'=> '+212'
            ],
            [
                'id'         => 143,
                'name'       => 'Mozambique',
                'short_code' => 'mz',
                'country_code'=> '+258'
            ],
            [
                'id'         => 144,
                'name'       => 'Myanmar',
                'short_code' => 'mm',
                'country_code'=> '+95'
            ],
            [
                'id'         => 145,
                'name'       => 'Namibia',
                'short_code' => 'na',
                'country_code'=> '+264'
            ],
            [
                'id'         => 146,
                'name'       => 'Nauru',
                'short_code' => 'nr',
                'country_code'=> '+674'
            ],
            [
                'id'         => 147,
                'name'       => 'Nepal',
                'short_code' => 'np',
                'country_code'=> '+977'
            ],
            [
                'id'         => 148,
                'name'       => 'Netherlands',
                'short_code' => 'nl',
                'country_code'=> '+31'
            ],
            [
                'id'         => 149,
                'name'       => 'Netherlands Antilles',
                'short_code' => 'an',
                'country_code'=> '+599'
            ],
            [
                'id'         => 150,
                'name'       => 'New Caledonia',
                'short_code' => 'nc',
                'country_code'=> '+687'
            ],
            [
                'id'         => 151,
                'name'       => 'New Zealand',
                'short_code' => 'nz',
                'country_code'=> '+64'
            ],
            [
                'id'         => 152,
                'name'       => 'Nicaragua',
                'short_code' => 'ni',
                'country_code'=> '+505',

            ],
            [
                'id'         => 153,
                'name'       => 'Niger',
                'short_code' => 'ne',
                'country_code'=> '+227',
            ],
            [
                'id'         => 154,
                'name'       => 'Nigeria',
                'short_code' => 'ng',
                'country_code'=> '+234',
            ],
            [
                'id'         => 155,
                'name'       => 'Niue',
                'short_code' => 'nu',
                'country_code'=> '+683',
            ],
            [
                'id'         => 156,
                'name'       => 'North Korea',
                'short_code' => 'kp',
                'country_code'=> '+850',
            ],
            [
                'id'         => 157,
                'name'       => 'Northern Mariana Islands',
                'short_code' => 'mp',
                'country_code'=> '+1',
            ],
            [
                'id'         => 158,
                'name'       => 'Norway',
                'short_code' => 'no',
                'country_code'=> '+47',
            ],
            [
                'id'         => 159,
                'name'       => 'Oman',
                'short_code' => 'om',
                'country_code'=> '+968',
            ],
            [
                'id'         => 160,
                'name'       => 'Pakistan',
                'short_code' => 'pk',
                'country_code'=> '+92',
            ],
            [
                'id'         => 161,
                'name'       => 'Palau',
                'short_code' => 'pw',
                'country_code'=> '+680',
            ],
            [
                'id'         => 162,
                'name'       => 'Palestine',
                'short_code' => 'ps',
                'country_code'=> '+970',
            ],
            [
                'id'         => 163,
                'name'       => 'Panama',
                'short_code' => 'pa',
                'country_code'=> '+507',
            ],
            [
                'id'         => 164,
                'name'       => 'Papua New Guinea',
                'short_code' => 'pg',
                'country_code'=> '+675',
            ],
            [
                'id'         => 165,
                'name'       => 'Paraguay',
                'short_code' => 'py',
                'country_code'=> '+595',
            ],
            [
                'id'         => 166,
                'name'       => 'Peru',
                'short_code' => 'pe',
                'country_code'=> '+51',
            ],
            [
                'id'         => 167,
                'name'       => 'Philippines',
                'short_code' => 'ph',
                'country_code'=> '+63',
            ],
            [
                'id'         => 168,
                'name'       => 'Pitcairn',
                'short_code' => 'pn',
                'country_code'=> '+64',
            ],
            [
                'id'         => 169,
                'name'       => 'Poland',
                'short_code' => 'pl',
                'country_code'=> '+48',
            ],
            [
                'id'         => 170,
                'name'       => 'Portugal',
                'short_code' => 'pt',
                'country_code'=> '+351',
            ],
            [
                'id'         => 171,
                'name'       => 'Puerto Rico',
                'short_code' => 'pr',
                'country_code'=> '+1',
            ],
            [
                'id'         => 172,
                'name'       => 'Qatar',
                'short_code' => 'qa',
                'country_code'=> '+974',
            ],
            [
                'id'         => 173,
                'name'       => 'Republic of the Congo',
                'short_code' => 'cg',
                'country_code'=> '+242',
            ],
            [
                'id'         => 174,
                'name'       => 'Reunion',
                'short_code' => 're',
                'country_code'=> '+262',
            ],
            [
                'id'         => 175,
                'name'       => 'Romania',
                'short_code' => 'ro',
                'country_code'=> '+40',
            ],
            [
                'id'         => 176,
                'name'       => 'Russia',
                'short_code' => 'ru',
                'country_code'=> '+7',
            ],
            [
                'id'         => 177,
                'name'       => 'Rwanda',
                'short_code' => 'rw',
                'country_code'=> '+7',
            ],
            [
                'id'         => 178,
                'name'       => 'Saint Barthelemy',
                'short_code' => 'bl',
                'country_code'=> '+590',
            ],
            [
                'id'         => 179,
                'name'       => 'Saint Helena',
                'short_code' => 'sh',
                'country_code'=> '+290',
            ],
            [
                'id'         => 180,
                'name'       => 'Saint Kitts and Nevis',
                'short_code' => 'kn',
                'country_code'=> '+1',
            ],
            [
                'id'         => 181,
                'name'       => 'Saint Lucia',
                'short_code' => 'lc',
                'country_code'=> '+1',
            ],
            [
                'id'         => 182,
                'name'       => 'Saint Martin',
                'short_code' => 'mf',
                'country_code'=> '+721',
            ],
            [
                'id'         => 183,
                'name'       => 'Saint Pierre and Miquelon',
                'short_code' => 'pm',
                'country_code'=> '+508',
            ],
            [
                'id'         => 184,
                'name'       => 'Saint Vincent and the Grenadines',
                'short_code' => 'vc',
                'country_code'=> '+1',
            ],
            [
                'id'         => 185,
                'name'       => 'Samoa',
                'short_code' => 'ws',
                'country_code'=> '+685',
            ],
            [
                'id'         => 186,
                'name'       => 'San Marino',
                'short_code' => 'sm',
                'country_code'=> '+378',
            ],
            [
                'id'         => 187,
                'name'       => 'Sao Tome and Principe',
                'short_code' => 'st',
                'country_code'=> '+239',

            ],
            [
                'id'         => 188,
                'name'       => 'Saudi Arabia',
                'short_code' => 'sa',
                'country_code'=> '+966',
            ],
            [
                'id'         => 189,
                'name'       => 'Senegal',
                'short_code' => 'sn',
                'country_code'=> '+221',
            ],
            [
                'id'         => 190,
                'name'       => 'Serbia',
                'short_code' => 'rs',
                'country_code'=> '+381',
            ],
            [
                'id'         => 191,
                'name'       => 'Seychelles',
                'short_code' => 'sc',
                'country_code'=> '+248',
            ],
            [
                'id'         => 192,
                'name'       => 'Sierra Leone',
                'short_code' => 'sl',
                'country_code'=> '+232',
            ],
            [
                'id'         => 193,
                'name'       => 'Singapore',
                'short_code' => 'sg',
                'country_code'=> '+65',
            ],
            [
                'id'         => 194,
                'name'       => 'Sint Maarten',
                'short_code' => 'sx',
                'country_code'=> '+721',

            ],
            [
                'id'         => 195,
                'name'       => 'Slovakia',
                'short_code' => 'sk',
                'country_code'=> '+421',
            ],
            [
                'id'         => 196,
                'name'       => 'Slovenia',
                'short_code' => 'si',
                'country_code'=> '+386',
            ],
            [
                'id'         => 197,
                'name'       => 'Solomon Islands',
                'short_code' => 'sb',
                'country_code'=> '+677',
            ],
            [
                'id'         => 198,
                'name'       => 'Somalia',
                'short_code' => 'so',
                'country_code'=> '+252',
            ],
            [
                'id'         => 199,
                'name'       => 'South Africa',
                'short_code' => 'za',
                'country_code'=> '+27',
            ],
            [
                'id'         => 200,
                'name'       => 'South Korea',
                'short_code' => 'kr',
                'country_code'=> '+82',
            ],
            [
                'id'         => 201,
                'name'       => 'South Sudan',
                'short_code' => 'ss',
                'country_code'=> '+211',
            ],
            [
                'id'         => 202,
                'name'       => 'Spain',
                'short_code' => 'es',
                'country_code'=> '+34',
            ],
            [
                'id'         => 203,
                'name'       => 'Sri Lanka',
                'short_code' => 'lk',
                'country_code'=> '+94',
            ],
            [
                'id'         => 204,
                'name'       => 'Sudan',
                'short_code' => 'sd',
                'country_code'=> '+249',
            ],
            [
                'id'         => 205,
                'name'       => 'Suriname',
                'short_code' => 'sr',
                'country_code'=> '+597',
            ],
            [
                'id'         => 206,
                'name'       => 'Svalbard and Jan Mayen',
                'short_code' => 'sj',
                'country_code'=> '+47',
            ],
            [
                'id'         => 207,
                'name'       => 'Swaziland',
                'short_code' => 'sz',
                'country_code'=> '+268',
            ],
            [
                'id'         => 208,
                'name'       => 'Sweden',
                'short_code' => 'se',
                'country_code'=> '+46',
            ],
            [
                'id'         => 209,
                'name'       => 'Switzerland',
                'short_code' => 'ch',
                'country_code'=> '+41',
            ],
            [
                'id'         => 210,
                'name'       => 'Syria',
                'short_code' => 'sy',
                'country_code'=> '+963',
            ],
            [
                'id'         => 211,
                'name'       => 'Taiwan',
                'short_code' => 'tw',
                'country_code'=> '+886',
            ],
            [
                'id'         => 212,
                'name'       => 'Tajikistan',
                'short_code' => 'tj',
                'country_code'=> '+992',
            ],
            [
                'id'         => 213,
                'name'       => 'Tanzania',
                'short_code' => 'tz',
                'country_code'=> '+255',
            ],
            [
                'id'         => 214,
                'name'       => 'Thailand',
                'short_code' => 'th',
                'country_code'=> '+66',
            ],
            [
                'id'         => 215,
                'name'       => 'Togo',
                'short_code' => 'tg',
                'country_code'=> '+228',
            ],
            [
                'id'         => 216,
                'name'       => 'Tokelau',
                'short_code' => 'tk',
                'country_code'=> '+690',
            ],
            [
                'id'         => 217,
                'name'       => 'Tonga',
                'short_code' => 'to',
                'country_code'=> '+676',
            ],
            [
                'id'         => 218,
                'name'       => 'Trinidad and Tobago',
                'short_code' => 'tt',
                'country_code'=> '+1',
            ],
            [
                'id'         => 219,
                'name'       => 'Tunisia',
                'short_code' => 'tn',
                'country_code'=> '+216',
            ],
            [
                'id'         => 220,
                'name'       => 'Turkey',
                'short_code' => 'tr',
                'country_code'=> '+90',
            ],
            [
                'id'         => 221,
                'name'       => 'Turkmenistan',
                'short_code' => 'tm',
                'country_code'=> '+993',
            ],
            [
                'id'         => 222,
                'name'       => 'Turks and Caicos Islands',
                'short_code' => 'tc',
                'country_code'=> '+1',
            ],
            [
                'id'         => 223,
                'name'       => 'Tuvalu',
                'short_code' => 'tv',
                  'country_code'=> '+688',
            ],
            [
                'id'         => 224,
                'name'       => 'U.S. Virgin Islands',
                'short_code' => 'vi',
                'country_code'=> '+1',
            ],
            [
                'id'         => 225,
                'name'       => 'Uganda',
                'short_code' => 'ug',
                'country_code'=> '+256',
            ],
            [
                'id'         => 226,
                'name'       => 'Ukraine',
                'short_code' => 'ua',
                'country_code'=> '+380',
            ],
            [
                'id'         => 227,
                'name'       => 'United Arab Emirates',
                'short_code' => 'ae',
                'country_code'=> '+971',
            ],
            [
                'id'         => 228,
                'name'       => 'United Kingdom',
                'short_code' => 'gb',
                'country_code'=> '+44',

            ],
            [
                'id'         => 229,
                'name'       => 'United States',
                'short_code' => 'us',
                'country_code'=> '+1',
            ],
            [
                'id'         => 230,
                'name'       => 'Uruguay',
                'short_code' => 'uy',
                'country_code'=> '+598',
            ],
            [
                'id'         => 231,
                'name'       => 'Uzbekistan',
                'short_code' => 'uz',
                'country_code'=> '+998',
            ],
            [
                'id'         => 232,
                'name'       => 'Vanuatu',
                'short_code' => 'vu',
                'country_code'=> '+678',
            ],
            [
                'id'         => 233,
                'name'       => 'Vatican',
                'short_code' => 'va',
                'country_code'=> '+379',
            ],
            [
                'id'         => 234,
                'name'       => 'Venezuela',
                'short_code' => 've',
                'country_code'=> '+58',
            ],
            [
                'id'         => 235,
                'name'       => 'Vietnam',
                'short_code' => 'vn',
                'country_code'=> '+84',
            ],
            [
                'id'         => 236,
                'name'       => 'Wallis and Futuna',
                'short_code' => 'wf',
                'country_code'=> '+681',
            ],
            [
                'id'         => 237,
                'name'       => 'Western Sahara',
                'short_code' => 'eh',
                'country_code'=> '+212',
            ],
            [
                'id'         => 238,
                'name'       => 'Yemen',
                'short_code' => 'ye',
                'country_code'=> '+967',
            ],
            [
                'id'         => 239,
                'name'       => 'Zambia',
                'short_code' => 'zm',
                'country_code'=> '+260',
            ],
            [
                'id'         => 240,
                'name'       => 'Zimbabwe',
                'short_code' => 'zw',
                'country_code'=> '+263',
            ],
        ];

        Country::insert($countries);
    }
}
