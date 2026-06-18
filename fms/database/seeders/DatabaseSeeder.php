<?php
namespace Database\Seeders;
use App\Models\{Airport,Flight,Ticket,Luggage,Shipment,CrewMember,User,FlightNotification};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // ── Airports ──────────────────────────────────────────
        $airportsData = [
            ['code'=>'JUB','name'=>'Juba International Airport','city'=>'Juba','country'=>'South Sudan'],
            ['code'=>'MAL','name'=>'Malakal Airport','city'=>'Malakal','country'=>'South Sudan'],
            ['code'=>'KOD','name'=>'Kodok Airstrip','city'=>'Kodok','country'=>'South Sudan'],
            ['code'=>'BOR','name'=>'Bor Airport','city'=>'Bor','country'=>'South Sudan'],
            ['code'=>'NYC','name'=>'John F. Kennedy International','city'=>'New York','country'=>'USA'],
            ['code'=>'LAX','name'=>'Los Angeles International','city'=>'Los Angeles','country'=>'USA'],
            ['code'=>'CHI','name'=>'O\'Hare International','city'=>'Chicago','country'=>'USA'],
            ['code'=>'MIA','name'=>'Miami International','city'=>'Miami','country'=>'USA'],
        ];
        foreach ($airportsData as $a) Airport::firstOrCreate(['code'=>$a['code']], $a);

        $juba = Airport::where('code','JUB')->first();
        $malakal = Airport::where('code','MAL')->first();
        $kodok = Airport::where('code','KOD')->first();
        $bor = Airport::where('code','BOR')->first();
        $nyc = Airport::where('code','NYC')->first();
        $lax = Airport::where('code','LAX')->first();
        $chi = Airport::where('code','CHI')->first();
        $mia = Airport::where('code','MIA')->first();

        // ── Users ─────────────────────────────────────────────
        $admin = User::firstOrCreate(['email'=>'admin@transroute.com'], ['name'=>'System Administrator','password'=>Hash::make('password'),'role'=>'admin','is_active'=>true]);

        $passengersData = [
            ['name'=>'Sarah Jenkins','email'=>'sarah.j@example.com','phone'=>'+1 555-901-2233'],
            ['name'=>'Marcus Thorne','email'=>'marcus.t@example.com','phone'=>'+1 555-014-7788'],
            ['name'=>'John Doe','email'=>'john.doe@example.com','phone'=>'555-0123'],
            ['name'=>'Alex Rivera','email'=>'alex.rivera@example.com','phone'=>'+1 555-220-9091'],
        ];
        $passengers = [];
        foreach ($passengersData as $p) {
            $passengers[] = User::firstOrCreate(['email'=>$p['email']], [...$p,'password'=>Hash::make('password'),'role'=>'passenger','is_active'=>true]);
        }
        [$sarah,$marcus,$john,$alex] = $passengers;

        // ── Flights ───────────────────────────────────────────
        $flightsData = [
            ['flight_number'=>'TR-1001','dep'=>$juba,'arr'=>$malakal,'dep_t'=>now()->addDays(2)->setTime(8,0),'arr_t'=>now()->addDays(2)->setTime(9,0),'gate'=>'A1','status'=>'scheduled'],
            ['flight_number'=>'TR-1002','dep'=>$juba,'arr'=>$bor,'dep_t'=>now()->addDays(4)->setTime(8,0),'arr_t'=>now()->addDays(4)->setTime(8,45),'gate'=>'A2','status'=>'scheduled'],
            ['flight_number'=>'TR-1003','dep'=>$malakal,'arr'=>$kodok,'dep_t'=>now()->addDays(6)->setTime(10,0),'arr_t'=>now()->addDays(6)->setTime(11,30),'gate'=>'B1','status'=>'scheduled'],
            ['flight_number'=>'TR-4921','dep'=>$chi,'arr'=>$nyc,'dep_t'=>now()->addMinutes(28),'arr_t'=>now()->addMinutes(140),'gate'=>'42','status'=>'boarding'],
            ['flight_number'=>'TR-4412','dep'=>$nyc,'arr'=>$lax,'dep_t'=>now()->subDays(1)->setTime(8,30),'arr_t'=>now()->subDays(1)->setTime(11,45),'gate'=>'C3','status'=>'arrived'],
            ['flight_number'=>'TR-8821','dep'=>$chi,'arr'=>$mia,'dep_t'=>now()->addHours(3),'arr_t'=>now()->addHours(6),'gate'=>'D5','status'=>'delayed'],
            ['flight_number'=>'TR-8210','dep'=>$mia,'arr'=>$nyc,'dep_t'=>now()->subDays(3),'arr_t'=>now()->subDays(3)->addHours(2),'gate'=>'E1','status'=>'arrived'],
        ];
        $flights = [];
        foreach ($flightsData as $f) {
            $flights[$f['flight_number']] = Flight::firstOrCreate(['flight_number'=>$f['flight_number']], [
                'airline'=>'TransRoute Airways','departure_airport_id'=>$f['dep']->id,'arrival_airport_id'=>$f['arr']->id,
                'departure_time'=>$f['dep_t'],'arrival_time'=>$f['arr_t'],'gate'=>$f['gate'],'capacity'=>150,'base_fare'=>120,'status'=>$f['status'],
            ]);
        }

        // ── Tickets ───────────────────────────────────────────
        $t1 = Ticket::firstOrCreate(['ticket_no'=>'TK-4412-A'], ['user_id'=>$sarah->id,'flight_id'=>$flights['TR-4412']->id,'seat_no'=>'A1','fare'=>120,'status'=>'completed']);
        $t2 = Ticket::firstOrCreate(['ticket_no'=>'TK-4412-B'], ['user_id'=>$marcus->id,'flight_id'=>$flights['TR-8821']->id,'seat_no'=>'B2','fare'=>120,'status'=>'confirmed']);
        $t3 = Ticket::firstOrCreate(['ticket_no'=>'TK-88210'], ['user_id'=>$john->id,'flight_id'=>$flights['TR-8210']->id,'seat_no'=>'A3','fare'=>120,'status'=>'completed']);
        $t4 = Ticket::firstOrCreate(['ticket_no'=>'TK-88244'], ['user_id'=>$john->id,'flight_id'=>$flights['TR-1002']->id,'seat_no'=>'B1','fare'=>120,'status'=>'pending']);
        $t5 = Ticket::firstOrCreate(['ticket_no'=>'TK-4921-A'], ['user_id'=>$sarah->id,'flight_id'=>$flights['TR-4921']->id,'seat_no'=>'A5','fare'=>120,'status'=>'confirmed']);
        $t6 = Ticket::firstOrCreate(['ticket_no'=>'TK-9921-X'], ['user_id'=>$alex->id,'flight_id'=>$flights['TR-8821']->id,'seat_no'=>'C1','fare'=>120,'status'=>'no_show']);

        // ── Luggage (admin-assigned only) ──────────────────────
        Luggage::firstOrCreate(['luggage_code'=>'LUG-9021'], ['ticket_id'=>$t1->id,'item_type'=>'Fragile - Glassware','description'=>'Large blue hardshell','weight'=>22,'fee'=>0,'status'=>'in_transit']);
        Luggage::firstOrCreate(['luggage_code'=>'LUG-8832'], ['ticket_id'=>$t6->id,'item_type'=>'Electronics','description'=>'Tech gear bag','weight'=>15,'fee'=>0,'status'=>'cancelled']);
        Luggage::firstOrCreate(['luggage_code'=>'LUG-0001'], ['ticket_id'=>$t5->id,'item_type'=>'Suitcase','description'=>'Large blue hardshell','weight'=>18,'fee'=>0,'status'=>'checked_in']);
        Luggage::firstOrCreate(['luggage_code'=>'LUG-0002'], ['ticket_id'=>$t5->id,'item_type'=>'Backpack','description'=>'Tech gear bag','weight'=>7,'fee'=>0,'status'=>'pending']);

        // ── Shipments (admin-assigned only) ────────────────────
        Shipment::firstOrCreate(['shipment_no'=>'SHP-2024-X1'], ['flight_id'=>$flights['TR-8821']->id,'ticket_id'=>null,'sender_name'=>'Global Parts Co','sender_phone'=>'+1 555-0123','receiver_name'=>'Tech Assemblers','receiver_phone'=>'+44 20 7946 0958','description'=>'4x Crates (Sensitive Components)','weight'=>320,'fee'=>2450,'status'=>'loaded']);
        Shipment::firstOrCreate(['shipment_no'=>'SHP-2024-X2'], ['flight_id'=>$flights['TR-4412']->id,'ticket_id'=>null,'sender_name'=>'Fresh Farms Ltd','sender_phone'=>'+1 555-9988','receiver_name'=>'City Markets','receiver_phone'=>'+1 555-1122','description'=>'12x Pallets (Perishable)','weight'=>980,'fee'=>1800,'status'=>'delivered']);
        Shipment::firstOrCreate(['shipment_no'=>'SHP-492'], ['flight_id'=>$flights['TR-4921']->id,'ticket_id'=>$t5->id,'sender_name'=>'Tech Corp','sender_phone'=>'+1 555-7777','receiver_name'=>'Sarah Jenkins','receiver_phone'=>'+1 555-901-2233','description'=>'Fragile Box','weight'=>5,'fee'=>45,'status'=>'in_transit']);

        // ── Crew ────────────────────────────────────────────────
        CrewMember::firstOrCreate(['email'=>'elena.vance@transroute.com'], ['name'=>'Capt. Elena Vance','role'=>'Senior Pilot','phone'=>'+1 555-0012','salary'=>145000,'status'=>'active']);
        CrewMember::firstOrCreate(['email'=>'david.aris@transroute.com'], ['name'=>'David Aris','role'=>'Logistics Lead','phone'=>'+1 555-0044','salary'=>95000,'status'=>'active']);

        // ── Notifications ───────────────────────────────────────
        FlightNotification::firstOrCreate(['user_id'=>$sarah->id,'type'=>'booking_confirmed','title'=>'Booking Confirmed'], ['ticket_id'=>$t5->id,'message'=>'Your booking for flight TR-4921 (CHI → NYC) has been confirmed.','sent_at'=>now()->subHours(2)]);
        FlightNotification::firstOrCreate(['user_id'=>$marcus->id,'type'=>'flight_delayed','title'=>'Flight Delayed'], ['ticket_id'=>$t2->id,'message'=>'Flight TR-8821 (CHI → MIA) delayed by 45 mins.','sent_at'=>now()->subMinutes(30)]);
        FlightNotification::firstOrCreate(['user_id'=>$john->id,'type'=>'arrival','title'=>'Arrival Confirmed'], ['ticket_id'=>$t3->id,'message'=>'Flight TR-8210 has landed in New York.','sent_at'=>now()->subDays(3)]);

        $this->command->info('✅ Seeded! admin@transroute.com / sarah.j@example.com / john.doe@example.com — all password: password');
    }
}
