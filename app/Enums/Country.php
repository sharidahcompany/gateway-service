<?php

namespace App\Enums;

enum Country: string
{
    case SAU = 'SAU'; // Saudi Arabia
    case ARE = 'ARE'; // United Arab Emirates
    case EGY = 'EGY'; // Egypt
    case USA = 'USA'; // United States
    case EUR = 'EUR'; // Eurozone
    case CAN = 'CAN'; // Canada
    case AFG = 'AFG'; // Afghanistan
    case ALB = 'ALB'; // Albania
    case ARM = 'ARM'; // Armenia
    case ARG = 'ARG'; // Argentina
    case AUS = 'AUS'; // Australia
    case AZE = 'AZE'; // Azerbaijan
    case BIH = 'BIH'; // Bosnia and Herzegovina
    case BGD = 'BGD'; // Bangladesh
    case BGR = 'BGR'; // Bulgaria
    case BHR = 'BHR'; // Bahrain
    case BDI = 'BDI'; // Burundi
    case BRN = 'BRN'; // Brunei
    case BOL = 'BOL'; // Bolivia
    case BRA = 'BRA'; // Brazil
    case BWA = 'BWA'; // Botswana
    case BLR = 'BLR'; // Belarus
    case BLZ = 'BLZ'; // Belize
    case COD = 'COD'; // Democratic Republic of the Congo
    case CHE = 'CHE'; // Switzerland
    case CHL = 'CHL'; // Chile
    case CHN = 'CHN'; // China
    case COL = 'COL'; // Colombia
    case CRI = 'CRI'; // Costa Rica
    case CPV = 'CPV'; // Cape Verde
    case CZE = 'CZE'; // Czech Republic
    case DJI = 'DJI'; // Djibouti
    case DNK = 'DNK'; // Denmark
    case DOM = 'DOM'; // Dominican Republic
    case DZA = 'DZA'; // Algeria
    case ERI = 'ERI'; // Eritrea
    case ETH = 'ETH'; // Ethiopia
    case GBR = 'GBR'; // United Kingdom
    case GEO = 'GEO'; // Georgia
    case GHA = 'GHA'; // Ghana
    case GIN = 'GIN'; // Guinea
    case GTM = 'GTM'; // Guatemala
    case HKG = 'HKG'; // Hong Kong
    case HND = 'HND'; // Honduras
    case HRV = 'HRV'; // Croatia
    case HUN = 'HUN'; // Hungary
    case IDN = 'IDN'; // Indonesia
    case ISR = 'ISR'; // Israel
    case IND = 'IND'; // India
    case IRQ = 'IRQ'; // Iraq
    case IRN = 'IRN'; // Iran
    case ISL = 'ISL'; // Iceland
    case JAM = 'JAM'; // Jamaica
    case JOR = 'JOR'; // Jordan
    case JPN = 'JPN'; // Japan
    case KEN = 'KEN'; // Kenya
    case KHM = 'KHM'; // Cambodia
    case KOR = 'KOR'; // South Korea
    case KWT = 'KWT'; // Kuwait
    case KAZ = 'KAZ'; // Kazakhstan
    case LBN = 'LBN'; // Lebanon
    case LKA = 'LKA'; // Sri Lanka
    case LBY = 'LBY'; // Libya
    case MAR = 'MAR'; // Morocco
    case MDA = 'MDA'; // Moldova
    case MDG = 'MDG'; // Madagascar
    case MKD = 'MKD'; // North Macedonia
    case MMR = 'MMR'; // Myanmar
    case MAC = 'MAC'; // Macau
    case MUS = 'MUS'; // Mauritius
    case MEX = 'MEX'; // Mexico
    case MYS = 'MYS'; // Malaysia
    case MOZ = 'MOZ'; // Mozambique
    case NAM = 'NAM'; // Namibia
    case NGA = 'NGA'; // Nigeria
    case NIC = 'NIC'; // Nicaragua
    case NOR = 'NOR'; // Norway
    case NPL = 'NPL'; // Nepal
    case NZL = 'NZL'; // New Zealand
    case OMN = 'OMN'; // Oman
    case PAN = 'PAN'; // Panama
    case PER = 'PER'; // Peru
    case PHL = 'PHL'; // Philippines
    case PAK = 'PAK'; // Pakistan
    case POL = 'POL'; // Poland
    case PRY = 'PRY'; // Paraguay
    case QAT = 'QAT'; // Qatar
    case ROU = 'ROU'; // Romania
    case SRB = 'SRB'; // Serbia
    case RUS = 'RUS'; // Russia
    case RWA = 'RWA'; // Rwanda
    case SDN = 'SDN'; // Sudan
    case SWE = 'SWE'; // Sweden
    case SGP = 'SGP'; // Singapore
    case SOM = 'SOM'; // Somalia
    case SYR = 'SYR'; // Syria
    case THA = 'THA'; // Thailand
    case TUN = 'TUN'; // Tunisia
    case TON = 'TON'; // Tonga
    case TUR = 'TUR'; // Turkey
    case TTO = 'TTO'; // Trinidad and Tobago
    case TWN = 'TWN'; // Taiwan
    case TZA = 'TZA'; // Tanzania
    case UKR = 'UKR'; // Ukraine
    case UGA = 'UGA'; // Uganda
    case URY = 'URY'; // Uruguay
    case UZB = 'UZB'; // Uzbekistan
    case VEN = 'VEN'; // Venezuela
    case VNM = 'VNM'; // Vietnam
    case CAF = 'CAF'; // Central African Republic
    case XOF = 'XOF'; // West Africa
    case YEM = 'YEM'; // Yemen
    case ZAF = 'ZAF'; // South Africa
    case ZMB = 'ZMB'; // Zambia

    public function iso2(): string
    {
        return self::countryData()[$this->value]['iso2'] ?? '';
    }

    public function flag(): string
    {
        $code = strtolower($this->iso2());
        return $code ? "https://flagcdn.com/{$code}.svg" : '';
    }

    public function label(): string
    {
        return trans('countries.' . $this->value);
    }

    public static function countryData(): array
    {
        return [
            'SAU' => ['iso2' => 'sa'],
            'ARE' => ['iso2' => 'ae'],
            'EGY' => ['iso2' => 'eg'],
            'USA' => ['iso2' => 'us'],
            'EUR' => ['iso2' => 'eu'],
            'CAN' => ['iso2' => 'ca'],
            'AFG' => ['iso2' => 'af'],
            'ALB' => ['iso2' => 'al'],
            'ARM' => ['iso2' => 'am'],
            'ARG' => ['iso2' => 'ar'],
            'AUS' => ['iso2' => 'au'],
            'AZE' => ['iso2' => 'az'],
            'BIH' => ['iso2' => 'ba'],
            'BGD' => ['iso2' => 'bd'],
            'BGR' => ['iso2' => 'bg'],
            'BHR' => ['iso2' => 'bh'],
            'BDI' => ['iso2' => 'bi'],
            'BRN' => ['iso2' => 'bn'],
            'BOL' => ['iso2' => 'bo'],
            'BRA' => ['iso2' => 'br'],
            'BWA' => ['iso2' => 'bw'],
            'BLR' => ['iso2' => 'by'],
            'BLZ' => ['iso2' => 'bz'],
            'COD' => ['iso2' => 'cd'],
            'CHE' => ['iso2' => 'ch'],
            'CHL' => ['iso2' => 'cl'],
            'CHN' => ['iso2' => 'cn'],
            'COL' => ['iso2' => 'co'],
            'CRI' => ['iso2' => 'cr'],
            'CPV' => ['iso2' => 'cv'],
            'CZE' => ['iso2' => 'cz'],
            'DJI' => ['iso2' => 'dj'],
            'DNK' => ['iso2' => 'dk'],
            'DOM' => ['iso2' => 'do'],
            'DZA' => ['iso2' => 'dz'],
            'ERI' => ['iso2' => 'er'],
            'ETH' => ['iso2' => 'et'],
            'GEO' => ['iso2' => 'ge'],
            'GHA' => ['iso2' => 'gh'],
            'GIN' => ['iso2' => 'gn'],
            'GTM' => ['iso2' => 'gt'],
            'HKG' => ['iso2' => 'hk'],
            'HND' => ['iso2' => 'hn'],
            'HRV' => ['iso2' => 'hr'],
            'HUN' => ['iso2' => 'hu'],
            'IDN' => ['iso2' => 'id'],
            'ISR' => ['iso2' => 'il'],
            'IND' => ['iso2' => 'in'],
            'IRQ' => ['iso2' => 'iq'],
            'IRN' => ['iso2' => 'ir'],
            'ISL' => ['iso2' => 'is'],
            'JAM' => ['iso2' => 'jm'],
            'JOR' => ['iso2' => 'jo'],
            'JPN' => ['iso2' => 'jp'],
            'KEN' => ['iso2' => 'ke'],
            'KHM' => ['iso2' => 'kh'],
            'KOR' => ['iso2' => 'kr'],
            'KWT' => ['iso2' => 'kw'],
            'KAZ' => ['iso2' => 'kz'],
            'LBN' => ['iso2' => 'lb'],
            'LKA' => ['iso2' => 'lk'],
            'LBY' => ['iso2' => 'ly'],
            'MAR' => ['iso2' => 'ma'],
            'MDA' => ['iso2' => 'md'],
            'MDG' => ['iso2' => 'mg'],
            'MKD' => ['iso2' => 'mk'],
            'MMR' => ['iso2' => 'mm'],
            'MAC' => ['iso2' => 'mo'],
            'MUS' => ['iso2' => 'mu'],
            'MEX' => ['iso2' => 'mx'],
            'MYS' => ['iso2' => 'my'],
            'MOZ' => ['iso2' => 'mz'],
            'NAM' => ['iso2' => 'na'],
            'NGA' => ['iso2' => 'ng'],
            'NIC' => ['iso2' => 'ni'],
            'NOR' => ['iso2' => 'no'],
            'NPL' => ['iso2' => 'np'],
            'NZL' => ['iso2' => 'nz'],
            'OMN' => ['iso2' => 'om'],
            'PAN' => ['iso2' => 'pa'],
            'PER' => ['iso2' => 'pe'],
            'PHL' => ['iso2' => 'ph'],
            'PAK' => ['iso2' => 'pk'],
            'POL' => ['iso2' => 'pl'],
            'PRY' => ['iso2' => 'py'],
            'QAT' => ['iso2' => 'qa'],
            'ROU' => ['iso2' => 'ro'],
            'SRB' => ['iso2' => 'rs'],
            'RUS' => ['iso2' => 'ru'],
            'RWA' => ['iso2' => 'rw'],
            'SDN' => ['iso2' => 'sd'],
            'SWE' => ['iso2' => 'se'],
            'SGP' => ['iso2' => 'sg'],
            'SOM' => ['iso2' => 'so'],
            'SYR' => ['iso2' => 'sy'],
            'THA' => ['iso2' => 'th'],
            'TUN' => ['iso2' => 'tn'],
            'TON' => ['iso2' => 'to'],
            'TUR' => ['iso2' => 'tr'],
            'TTO' => ['iso2' => 'tt'],
            'TWN' => ['iso2' => 'tw'],
            'TZA' => ['iso2' => 'tz'],
            'UKR' => ['iso2' => 'ua'],
            'UGA' => ['iso2' => 'ug'],
            'URY' => ['iso2' => 'uy'],
            'UZB' => ['iso2' => 'uz'],
            'VEN' => ['iso2' => 've'],
            'VNM' => ['iso2' => 'vn'],
            'CAF' => ['iso2' => 'cf'],
            'XOF' => ['iso2' => 'sn'],
            'YEM' => ['iso2' => 'ye'],
            'ZAF' => ['iso2' => 'za'],
            'ZMB' => ['iso2' => 'zm'],
        ];
    }

    public static function all(): array
    {
        return array_map(
            fn($case) => [
                'iso3' => $case->value,
                'iso2' => $case->iso2(),
                'flag' => $case->flag(),
                'label' => $case->label(),
            ],
            self::cases()
        );
    }
}
