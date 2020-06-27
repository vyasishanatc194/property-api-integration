<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;

use App\Tasks;
use App\User;

class DailyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailyUpdate:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		if(Carbon::now()->startOfWeek()->format("Y-m-d") == Carbon::now()->format("Y-m-d")){
			$this->createNew();
		}
		//if(date('H:00:00') == "13:00:00")
		if(Carbon::now()->endOfWeek()->format("Y-m-d") == Carbon::now()->format("Y-m-d") || Carbon::now()->format("Y-m-d") == "2019-08-27"){
			$this->freeEmployee();
		}
	}
	public function freeEmployee()
    {
		$tasks = Tasks::where('status','!=','closed')->get();
		foreach($tasks as $task){
			
			$start = strtotime(Carbon::now()->format("Y-m-d")." 10:00:00");
			$end =  strtotime(Carbon::now()->format("Y-m-d")." 13:00:00");
			
			$start2 = strtotime(Carbon::now()->subDays(1)->format("Y-m-d")." 10:00:00");
			$end2 =  strtotime(Carbon::now()->subDays(1)->format("Y-m-d")." 23:00:00");
			
			$start3 = strtotime(Carbon::now()->subDays(1)->format("Y-m-d")." 15:00:00");
			$end3 =  strtotime(Carbon::now()->subDays(1)->format("Y-m-d")." 23:00:00");


			$arr = [date("Y-m-d H:i:s", rand($start, $end)),date("Y-m-d H:i:s", rand($start2, $end2)),date("Y-m-d H:i:s", rand($start3, $end3))] ;
			$key = array_rand($arr);
		
			$task->status = 'closed';
			$task->closed_at = $arr[$key];
			$task->updated_at = $arr[$key];
			$task->save();
			
			$uid = $task->hascode;
			if($uid && $uid != ""){
				$path = public_path('task-files') .'/'.$uid;
				if(\File::exists($path)){
					\File::deleteDirectory($path);
				}
			}
		}
	}
	public function createNew()
    {
		$admins = User::where('utype','admin')->pluck('id')->toArray();
		
		if(is_array($admins) && isset($admins[0])){
			
		}else{
			$admins = [1];
		}
		
		$not_free_user = Tasks::where('status','!=','closed')->pluck('user_id')->toArray();
        $users = User::where('utype','=','employee')->where('status','=','active')->whereNotIn("id",array_filter($not_free_user))->inRandomOrder()->get();
		
		$start = strtotime("09:00:00");
		$end =  strtotime("13:00:59");
		
		
		foreach($users as $usr){
			
			$randomDate = date("Y-m-d H:i:s",rand($start, $end));
		
			$subject_time = Carbon::createFromFormat("Y-m-d H:i:s",$randomDate)->format('jS')." - ".Carbon::createFromFormat("Y-m-d H:i:s",$randomDate)->addDays(5)->format('jS M Y');
			$exp_date = Carbon::createFromFormat("Y-m-d H:i:s",$randomDate)->addDays(2)->format('Y-m-d');
			$total_file = rand(1,3);
			$total_size = rand(2,100) * 1048576 + rand(100,1048576);
			$saz = formatSizeUnits($total_size);
			$uid = MD5(uniqid());
		
			$admin_id = $admins[array_rand($admins)];
			$data = array(
				'subject' => 'Data Processing task ('.$subject_time.')',
				'content' => json_encode(['exp_date'=>$exp_date,'total_file'=>$total_file,'total_size'=>$saz,'desc'=>'']),
				'created_by' => $admin_id,
				'updated_by' => $admin_id,
				'hascode' => $uid,
				'user_id' => $usr->id,
				'status' => 'open',
				'created_at' => $randomDate,
				'updated_at' => $randomDate,
			);
			//echo "<pre>"; print_r($data);
			$module = Tasks::create($data);
			
			$path = public_path('task-files') .'/'.$uid;
			\File::exists($path) or mkdir($path, 0777, true);
		}
		
		$timesort = Tasks::where('status','open')->orderby("created_at","asc")->pluck('created_at')->toArray();
		$tasks = Tasks::where('status','open')->orderby("id","asc")->get();
		
		foreach($tasks as $k=>$task){
			$task->created_at = $timesort[$k];
			$task->updated_at = $timesort[$k];
			$task->save();
		}
		
		
	}
}
