<?php

namespace App\Enums;

enum Currency: string
{
    case SAR = 'SAR';
    case AED = 'AED';
    case USD = 'USD';
    case EUR = 'EUR';
    case CAD = 'CAD';
    case AFN = 'AFN';
    case ALL = 'ALL';
    case AMD = 'AMD';
    case ARS = 'ARS';
    case AUD = 'AUD';
    case AZN = 'AZN';
    case BAM = 'BAM';
    case BDT = 'BDT';
    case BGN = 'BGN';
    case BHD = 'BHD';
    case BIF = 'BIF';
    case BND = 'BND';
    case BOB = 'BOB';
    case BRL = 'BRL';
    case BWP = 'BWP';
    case BYN = 'BYN';
    case BZD = 'BZD';
    case CDF = 'CDF';
    case CHF = 'CHF';
    case CLP = 'CLP';
    case CNY = 'CNY';
    case COP = 'COP';
    case CRC = 'CRC';
    case CVE = 'CVE';
    case CZK = 'CZK';
    case DJF = 'DJF';
    case DKK = 'DKK';
    case DOP = 'DOP';
    case DZD = 'DZD';
    case EGP = 'EGP';
    case ERN = 'ERN';
    case ETB = 'ETB';
    case GBP = 'GBP';
    case GEL = 'GEL';
    case GHS = 'GHS';
    case GNF = 'GNF';
    case GTQ = 'GTQ';
    case HKD = 'HKD';
    case HNL = 'HNL';
    case HRK = 'HRK';
    case HUF = 'HUF';
    case IDR = 'IDR';
    case ILS = 'ILS';
    case INR = 'INR';
    case IQD = 'IQD';
    case IRR = 'IRR';
    case ISK = 'ISK';
    case JMD = 'JMD';
    case JOD = 'JOD';
    case JPY = 'JPY';
    case KES = 'KES';
    case KHR = 'KHR';
    case KMF = 'KMF';
    case KRW = 'KRW';
    case KWD = 'KWD';
    case KZT = 'KZT';
    case LBP = 'LBP';
    case LKR = 'LKR';
    case LYD = 'LYD';
    case MAD = 'MAD';
    case MDL = 'MDL';
    case MGA = 'MGA';
    case MKD = 'MKD';
    case MMK = 'MMK';
    case MOP = 'MOP';
    case MUR = 'MUR';
    case MXN = 'MXN';
    case MYR = 'MYR';
    case MZN = 'MZN';
    case NAD = 'NAD';
    case NGN = 'NGN';
    case NIO = 'NIO';
    case NOK = 'NOK';
    case NPR = 'NPR';
    case NZD = 'NZD';
    case OMR = 'OMR';
    case PAB = 'PAB';
    case PEN = 'PEN';
    case PHP = 'PHP';
    case PKR = 'PKR';
    case PLN = 'PLN';
    case PYG = 'PYG';
    case QAR = 'QAR';
    case RON = 'RON';
    case RSD = 'RSD';
    case RUB = 'RUB';
    case RWF = 'RWF';
    case SDG = 'SDG';
    case SEK = 'SEK';
    case SGD = 'SGD';
    case SOS = 'SOS';
    case SYP = 'SYP';
    case THB = 'THB';
    case TND = 'TND';
    case TOP = 'TOP';
    case TRY = 'TRY';
    case TTD = 'TTD';
    case TWD = 'TWD';
    case TZS = 'TZS';
    case UAH = 'UAH';
    case UGX = 'UGX';
    case UYU = 'UYU';
    case UZS = 'UZS';
    case VES = 'VES';
    case VND = 'VND';
    case XAF = 'XAF';
    case XOF = 'XOF';
    case YER = 'YER';
    case ZAR = 'ZAR';
    case ZMW = 'ZMW';

    public function symbol(): string
    {
        return self::currencyData()[$this->value]['symbol'] ?? $this->value;
    }

    public function country(): string
    {
        return self::currencyData()[$this->value]['country'] ?? '';
    }

    public function flag(): string
    {
        $countryCode = strtolower(self::currencyData()[$this->value]['country_code'] ?? '');
        if ($countryCode) {
            return "https://flagcdn.com/{$countryCode}.svg";
        }
        return '';
    }

    public function label(): string
    {
        return trans('currencies.' . $this->value);
    }

    public static function currencyData(): array
    {
        return [
            'SAR' => ['symbol' => 'ر.س', 'country' => 'Saudi Arabia', 'country_code' => 'sa'],
            'AED' => ['symbol' => 'د.إ', 'country' => 'United Arab Emirates', 'country_code' => 'ae'],
            'USD' => ['symbol' => '$', 'country' => 'United States', 'country_code' => 'us'],
            'EUR' => ['symbol' => '€', 'country' => 'Eurozone', 'country_code' => 'eu'],
            'CAD' => ['symbol' => '$', 'country' => 'Canada', 'country_code' => 'ca'],
            'AFN' => ['symbol' => '؋', 'country' => 'Afghanistan', 'country_code' => 'af'],
            'ALL' => ['symbol' => 'Lek', 'country' => 'Albania', 'country_code' => 'al'],
            'AMD' => ['symbol' => '֏', 'country' => 'Armenia', 'country_code' => 'am'],
            'ARS' => ['symbol' => '$', 'country' => 'Argentina', 'country_code' => 'ar'],
            'AUD' => ['symbol' => '$', 'country' => 'Australia', 'country_code' => 'au'],
            'AZN' => ['symbol' => '₼', 'country' => 'Azerbaijan', 'country_code' => 'az'],
            'BAM' => ['symbol' => 'KM', 'country' => 'Bosnia and Herzegovina', 'country_code' => 'ba'],
            'BDT' => ['symbol' => '৳', 'country' => 'Bangladesh', 'country_code' => 'bd'],
            'BGN' => ['symbol' => 'лв', 'country' => 'Bulgaria', 'country_code' => 'bg'],
            'BHD' => ['symbol' => '.د.ب', 'country' => 'Bahrain', 'country_code' => 'bh'],
            'BIF' => ['symbol' => 'Fr', 'country' => 'Burundi', 'country_code' => 'bi'],
            'BND' => ['symbol' => '$', 'country' => 'Brunei', 'country_code' => 'bn'],
            'BOB' => ['symbol' => 'Bs.', 'country' => 'Bolivia', 'country_code' => 'bo'],
            'BRL' => ['symbol' => 'R$', 'country' => 'Brazil', 'country_code' => 'br'],
            'BWP' => ['symbol' => 'P', 'country' => 'Botswana', 'country_code' => 'bw'],
            'BYN' => ['symbol' => 'Br', 'country' => 'Belarus', 'country_code' => 'by'],
            'BZD' => ['symbol' => '$', 'country' => 'Belize', 'country_code' => 'bz'],
            'CDF' => ['symbol' => 'Fr', 'country' => 'Democratic Republic of the Congo', 'country_code' => 'cd'],
            'CHF' => ['symbol' => 'CHF', 'country' => 'Switzerland', 'country_code' => 'ch'],
            'CLP' => ['symbol' => '$', 'country' => 'Chile', 'country_code' => 'cl'],
            'CNY' => ['symbol' => '¥', 'country' => 'China', 'country_code' => 'cn'],
            'COP' => ['symbol' => '$', 'country' => 'Colombia', 'country_code' => 'co'],
            'CRC' => ['symbol' => '₡', 'country' => 'Costa Rica', 'country_code' => 'cr'],
            'CVE' => ['symbol' => '$', 'country' => 'Cape Verde', 'country_code' => 'cv'],
            'CZK' => ['symbol' => 'Kč', 'country' => 'Czech Republic', 'country_code' => 'cz'],
            'DJF' => ['symbol' => 'Fr', 'country' => 'Djibouti', 'country_code' => 'dj'],
            'DKK' => ['symbol' => 'kr', 'country' => 'Denmark', 'country_code' => 'dk'],
            'DOP' => ['symbol' => 'RD$', 'country' => 'Dominican Republic', 'country_code' => 'do'],
            'DZD' => ['symbol' => 'د.ج', 'country' => 'Algeria', 'country_code' => 'dz'],
            'EGP' => ['symbol' => 'ج.م', 'country' => 'Egypt', 'country_code' => 'eg'],
            'ERN' => ['symbol' => 'Nfk', 'country' => 'Eritrea', 'country_code' => 'er'],
            'ETB' => ['symbol' => 'Br', 'country' => 'Ethiopia', 'country_code' => 'et'],
            'GBP' => ['symbol' => '£', 'country' => 'United Kingdom', 'country_code' => 'gb'],
            'GEL' => ['symbol' => '₾', 'country' => 'Georgia', 'country_code' => 'ge'],
            'GHS' => ['symbol' => '₵', 'country' => 'Ghana', 'country_code' => 'gh'],
            'GNF' => ['symbol' => 'Fr', 'country' => 'Guinea', 'country_code' => 'gn'],
            'GTQ' => ['symbol' => 'Q', 'country' => 'Guatemala', 'country_code' => 'gt'],
            'HKD' => ['symbol' => '$', 'country' => 'Hong Kong', 'country_code' => 'hk'],
            'HNL' => ['symbol' => 'L', 'country' => 'Honduras', 'country_code' => 'hn'],
            'HRK' => ['symbol' => 'kn', 'country' => 'Croatia', 'country_code' => 'hr'],
            'HUF' => ['symbol' => 'Ft', 'country' => 'Hungary', 'country_code' => 'hu'],
            'IDR' => ['symbol' => 'Rp', 'country' => 'Indonesia', 'country_code' => 'id'],
            'ILS' => ['symbol' => '₪', 'country' => 'Israel', 'country_code' => 'il'],
            'INR' => ['symbol' => '₹', 'country' => 'India', 'country_code' => 'in'],
            'IQD' => ['symbol' => 'ع.د', 'country' => 'Iraq', 'country_code' => 'iq'],
            'IRR' => ['symbol' => '﷼', 'country' => 'Iran', 'country_code' => 'ir'],
            'ISK' => ['symbol' => 'kr', 'country' => 'Iceland', 'country_code' => 'is'],
            'JMD' => ['symbol' => '$', 'country' => 'Jamaica', 'country_code' => 'jm'],
            'JOD' => ['symbol' => 'د.ا', 'country' => 'Jordan', 'country_code' => 'jo'],
            'JPY' => ['symbol' => '¥', 'country' => 'Japan', 'country_code' => 'jp'],
            'KES' => ['symbol' => 'Sh', 'country' => 'Kenya', 'country_code' => 'ke'],
            'KHR' => ['symbol' => '៛', 'country' => 'Cambodia', 'country_code' => 'kh'],
            'KMF' => ['symbol' => 'Fr', 'country' => 'Comoros', 'country_code' => 'km'],
            'KRW' => ['symbol' => '₩', 'country' => 'South Korea', 'country_code' => 'kr'],
            'KWD' => ['symbol' => 'د.ك', 'country' => 'Kuwait', 'country_code' => 'kw'],
            'KZT' => ['symbol' => '₸', 'country' => 'Kazakhstan', 'country_code' => 'kz'],
            'LBP' => ['symbol' => 'ل.ل', 'country' => 'Lebanon', 'country_code' => 'lb'],
            'LKR' => ['symbol' => 'Rs', 'country' => 'Sri Lanka', 'country_code' => 'lk'],
            'LYD' => ['symbol' => 'ل.د', 'country' => 'Libya', 'country_code' => 'ly'],
            'MAD' => ['symbol' => 'د.م', 'country' => 'Morocco', 'country_code' => 'ma'],
            'MDL' => ['symbol' => 'L', 'country' => 'Moldova', 'country_code' => 'md'],
            'MGA' => ['symbol' => 'Ar', 'country' => 'Madagascar', 'country_code' => 'mg'],
            'MKD' => ['symbol' => 'ден', 'country' => 'North Macedonia', 'country_code' => 'mk'],
            'MMK' => ['symbol' => 'Ks', 'country' => 'Myanmar', 'country_code' => 'mm'],
            'MOP' => ['symbol' => 'MOP$', 'country' => 'Macau', 'country_code' => 'mo'],
            'MUR' => ['symbol' => '₨', 'country' => 'Mauritius', 'country_code' => 'mu'],
            'MXN' => ['symbol' => '$', 'country' => 'Mexico', 'country_code' => 'mx'],
            'MYR' => ['symbol' => 'RM', 'country' => 'Malaysia', 'country_code' => 'my'],
            'MZN' => ['symbol' => 'MTn', 'country' => 'Mozambique', 'country_code' => 'mz'],
            'NAD' => ['symbol' => '$', 'country' => 'Namibia', 'country_code' => 'na'],
            'NGN' => ['symbol' => '₦', 'country' => 'Nigeria', 'country_code' => 'ng'],
            'NIO' => ['symbol' => 'C$', 'country' => 'Nicaragua', 'country_code' => 'ni'],
            'NOK' => ['symbol' => 'kr', 'country' => 'Norway', 'country_code' => 'no'],
            'NPR' => ['symbol' => '₨', 'country' => 'Nepal', 'country_code' => 'np'],
            'NZD' => ['symbol' => '$', 'country' => 'New Zealand', 'country_code' => 'nz'],
            'OMR' => ['symbol' => 'ر.ع.', 'country' => 'Oman', 'country_code' => 'om'],
            'PAB' => ['symbol' => 'B/.', 'country' => 'Panama', 'country_code' => 'pa'],
            'PEN' => ['symbol' => 'S/.', 'country' => 'Peru', 'country_code' => 'pe'],
            'PHP' => ['symbol' => '₱', 'country' => 'Philippines', 'country_code' => 'ph'],
            'PKR' => ['symbol' => '₨', 'country' => 'Pakistan', 'country_code' => 'pk'],
            'PLN' => ['symbol' => 'zł', 'country' => 'Poland', 'country_code' => 'pl'],
            'PYG' => ['symbol' => '₲', 'country' => 'Paraguay', 'country_code' => 'py'],
            'QAR' => ['symbol' => 'ر.ق', 'country' => 'Qatar', 'country_code' => 'qa'],
            'RON' => ['symbol' => 'lei', 'country' => 'Romania', 'country_code' => 'ro'],
            'RSD' => ['symbol' => 'дин.', 'country' => 'Serbia', 'country_code' => 'rs'],
            'RUB' => ['symbol' => '₽', 'country' => 'Russia', 'country_code' => 'ru'],
            'RWF' => ['symbol' => 'Fr', 'country' => 'Rwanda', 'country_code' => 'rw'],
            'SDG' => ['symbol' => 'ج.س.', 'country' => 'Sudan', 'country_code' => 'sd'],
            'SEK' => ['symbol' => 'kr', 'country' => 'Sweden', 'country_code' => 'se'],
            'SGD' => ['symbol' => '$', 'country' => 'Singapore', 'country_code' => 'sg'],
            'SOS' => ['symbol' => 'Sh', 'country' => 'Somalia', 'country_code' => 'so'],
            'SYP' => ['symbol' => '£S', 'country' => 'Syria', 'country_code' => 'sy'],
            'THB' => ['symbol' => '฿', 'country' => 'Thailand', 'country_code' => 'th'],
            'TND' => ['symbol' => 'د.ت', 'country' => 'Tunisia', 'country_code' => 'tn'],
            'TOP' => ['symbol' => 'T$', 'country' => 'Tonga', 'country_code' => 'to'],
            'TRY' => ['symbol' => '₺', 'country' => 'Turkey', 'country_code' => 'tr'],
            'TTD' => ['symbol' => 'TT$', 'country' => 'Trinidad and Tobago', 'country_code' => 'tt'],
            'TWD' => ['symbol' => 'NT$', 'country' => 'Taiwan', 'country_code' => 'tw'],
            'TZS' => ['symbol' => 'Sh', 'country' => 'Tanzania', 'country_code' => 'tz'],
            'UAH' => ['symbol' => '₴', 'country' => 'Ukraine', 'country_code' => 'ua'],
            'UGX' => ['symbol' => 'Sh', 'country' => 'Uganda', 'country_code' => 'ug'],
            'UYU' => ['symbol' => '$', 'country' => 'Uruguay', 'country_code' => 'uy'],
            'UZS' => ['symbol' => 'лв', 'country' => 'Uzbekistan', 'country_code' => 'uz'],
            'VES' => ['symbol' => 'Bs.', 'country' => 'Venezuela', 'country_code' => 've'],
            'VND' => ['symbol' => '₫', 'country' => 'Vietnam', 'country_code' => 'vn'],
            'XAF' => ['symbol' => 'Fr', 'country' => 'Central African Republic (CFA)', 'country_code' => 'cf'],
            'XOF' => ['symbol' => 'Fr', 'country' => 'West African Economic and Monetary Union (CFA)', 'country_code' => 'sn'],
            'YER' => ['symbol' => '﷼', 'country' => 'Yemen', 'country_code' => 'ye'],
            'ZAR' => ['symbol' => 'R', 'country' => 'South Africa', 'country_code' => 'za'],
            'ZMW' => ['symbol' => 'ZK', 'country' => 'Zambia', 'country_code' => 'zm'],
        ];
    }

    public static function all(): array
    {
        return array_map(
            fn($case) => [
                'code' => $case->value,
                'label' => $case->label(),
                'symbol' => $case->symbol(),
                'flag' => $case->flag(),
            ],
            self::cases()
        );
    }
}
