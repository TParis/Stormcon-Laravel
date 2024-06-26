<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Contact;
use Laravel\Scout\Searchable;


class Company extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = ['name', 'legal_name', 'also_known_as', 'phone', 'fax', 'address', 'city', 'state', 'website',
        'zipcode', 'type', 'division', 'num_of_employees', 'federal_tax_id', 'state_tax_id', 'sos', 'cn', 'sic'];

    public static $roles = [
        "Developer" => "Developer",
        "Electric Provider" => "Electric Provider",
        "Electric Contractor" => "Electric Contractor",
        "Gas Provider" => "Gas Provider",
        "Gas Contractor" => "Gas Contractor",
        "Owner" => "Owner",
        "General Contractor" => "General Contractor",
        "Excavation" => "Excavation",
        "Wet Utility" => "Wet Utility",
        "Dry Utility" => "Dry Utility",
        "Paving" => "Paving",
        "Engineer" => "Engineer",
        "SWPPP Preparer" => "SWPPP Preparer",
        "Controls plans and spec" => "Controls plans and spec"
    ];

    public static $states = [
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'DC' => 'District Of Columbia',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PA' => 'Pennsylvania',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VA' => 'Virginia',
        'WA' => 'Washington',
        'WV' => 'West Virginia',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming',
        "Alabama" => "Alabama",
        "Alaska" => "Alaska",
        "Arizona" => "Arizona",
        "Arkansas" => "Arkansas",
        "California" => "California",
        "Colorado" => "Colorado",
        "Connecticut" => "Connecticut",
        "Delaware" => "Delaware",
        "District Of Columbia" => "District Of Columbia",
        "Florida" => "Florida",
        "Georgia" => "Georgia",
        "Hawaii" => "Hawaii",
        "Idaho" => "Idaho",
        "Illinois" => "Illinois",
        "Indiana" => "Indiana",
        "Iowa" => "Iowa",
        "Kansas" => "Kansas",
        "Kentucky" => "Kentucky",
        "Louisiana" => "Louisiana",
        "Maine" => "Maine",
        "Maryland" => "Maryland",
        "Massachusetts" => "Massachusetts",
        "Michigan" => "Michigan",
        "Minnesota" => "Minnesota",
        "Mississippi" => "Mississippi",
        "Missouri" => "Missouri",
        "Montana" => "Montana",
        "Nebraska" => "Nebraska",
        "Nevada" => "Nevada",
        "New Hampshire" => "New Hampshire",
        "New Jersey" => "New Jersey",
        "New Mexico" => "New Mexico",
        "New York" => "New York",
        "North Carolina" => "North Carolina",
        "North Dakota" => "North Dakota",
        "Ohio" => "Ohio",
        "Oklahoma" => "Oklahoma",
        "Oregon" => "Oregon",
        "Pennsylvania" => "Pennsylvania",
        "Rhode Island" => "Rhode Island",
        "South Carolina" => "South Carolina",
        "South Dakota" => "South Dakota",
        "Tennessee" => "Tennessee",
        "Texas" => "Texas",
        "Utah" => "Utah",
        "Vermont" => "Vermont",
        "Virginia" => "Virginia",
        "Washington" => "Washington",
        "West Virginia" => "West Virginia",
        "Wisconsin" => "Wisconsin",
        "Wyoming" => "Wyoming",
    ];

    public function counties() {
        return $this->belongsToMany(County::class);
    }

    public function contacts() {
        return $this->morphMany(Contact::class, "employer");
    }
}
