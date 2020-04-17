<?php

namespace App\Http\Controllers\student;

use App\announce;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use strtotime;



class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=> ['showAnnounce']]);
    }

    public function index()
    {
        // add table => day , time แล้วลบ schedule
        $id = Auth::id();
        // $courses = DB::table('enroll')
        //     ->where(['idstudent' => $id])->get();

        // foreach ($courses as $course){

        //     $enrolls=DB::table('enroll')->join('course','enroll.idcourse', '=', 'course.idcourse')
        //     ->join('tutor', 'tutor.idtutor', '=', 'enroll.idtutor')
        //     ->where(['enroll.idcourse' => [$course->idcourse]])
        //     ->where(['tutor.idtutor' => [$course->idTutor]])
        //     ->get();
        // }
        $today = Carbon::today();


        /*$enrolls = DB::SELECT('SELECT * FROM courses join tutors using (idTutor)
        join enroll using (idcourse)
        where enroll.idstudent = ? and end_date > ? ',[$id,$today->format('Y-m-d')]);*/

        $enrolls=DB::table('enroll')->join('courses','enroll.idcourse', '=', 'courses.idcourse')
            ->join('tutors', 'tutors.idtutor', '=', 'enroll.idtutor')
            ->where(['enroll.idstudent' => $id])
            ->whereDate('courses.end_date', '>', $today->format('Y-m-d') )
            ->get();

        if($enrolls != null){
           return view('student/enrollment',['enrolls' => $enrolls]);
        }else{
            return redirect('/enroll')->with('error','no course that enrollment');
        }


    }

    public function editProfile(){
        $id = Auth::id();
        $students = DB::table('students')
        ->where(['idstudent' => $id])->get();
        return view('student.editProfileStudent', ['students' => $students]);
    }

    public function editCheck(request $request){
        $Fname=$request->input('Fname');
        $Lname=$request->input('Lname');
        $email=$request->input('email');
        $phone=$request->input('phone');
        $address=$request->input('address');
        $id = Auth::id();
        $haveEmail = DB::table('students')->where(['email' => $email])->exists();

        $SEmail = DB::table('students')
        ->select('email')
        ->where([
            ['idstudent','=', $id],
            ['email', '=', $email]
            ])->get();

        if($haveEmail){
            if($SEmail == "[]"){
                return redirect()->back()->with('haveEmail', 'This Email is duplicate');
            }
        }

        if($Fname === null or $Lname === null or $email === null or $phone === null ) {

            return redirect()->back()->with('null','Please fill all required field.');
        }else{
            DB::table('students')
            ->where(['idstudent' => $id])
            ->update(
            [ 'Fname' => $Fname,
            'Lname' => $Lname,
            'email' => $email,
            'phone' => $phone,
            'address' => $address]
            );

            DB::table('users')
            ->where(['id' => $id])
            ->update(
                ['name' =>$Fname,
                'email' => $email,]
            );
            return redirect('/studentEdit')->with('success','success update');
        }
    }

    public function reviewFrom(){
        $id = Auth::id();

        $list = DB::select("SELECT * FROM enroll
                LEFT JOIN tutors ON enroll.idTutor = tutors.idTutor
                LEFT JOIN courses ON enroll.idcourse = courses.idcourse
                WHERE enroll.idstudent = '$id'
                AND courses.end_date < CURRENT_DATE()
                AND courses.idcourse NOT IN( SELECT idcourse FROM review WHERE idstudent = '$id' )");

        return view('student.review', ['list' => $list]);
    }

    public function addReview(request $request){
        $id = Auth::id();   //id student
        $idTutor = $request->input('idTutor');
        $idCourse = $request->input('idCourse');
        $rate = $request->input('rating');
        $comment = $request->input('review-comment');
        if($rate===null or $idCourse===null){
            redirect()->back()->with('null','Review incompleted');
        }else
        DB::table('review')->insert(
            ['idTutor' => $idTutor,
            'idcourse' => $idCourse,
            'idstudent' => $id,
            'review' => $rate,
            'comment' => $comment,
            'date' => now()]
        );
        return  redirect()->back()->with('pass','Review completed');
    }

    public function Announce(){
        $id = Auth::id();
        $Anns = DB::table('announces')
        ->where(['idstudent' => $id])->get();

        return view('course.announce',['Anns' => $Anns]);
    }

    public function AddAnnounce(request $request){
        $id = Auth::id();
        $idAnn=announce::max('idAnnounce');

        if($idAnn === null){$idAnnounce = 0 ;}
            $idAnnounce=$idAnn +1;
        $Ann = $request->input('Ann');
        $contact = $request->input('phone');
        $sex = $request->input('sex');
        $level = $request->input('level');
        $location = $request->input('loca');
        $date = date('d M Y');

        DB::table('announces')->insert(
            ['idAnnounce' => $idAnnounce,
            'idstudent' => $id,
            'sex' => $sex,
            'level' => $level,
            'location' => $location,
            'contact' => $contact,
            'announce' => $Ann,
            'date' => $date]
        );
        return  redirect('/student/announce')->with('success','Add announce completed');
    }

    public function DeleteAnnounce(request $request){
        $idAnn = $request->input('idAnnounce');
        DB::table('announces')
        ->where(['idAnnounce' => $idAnn])->delete();
        return redirect()->back()->with('success','success');
    }

    public function showAnnounce(){
        // $ann = DB::table('announces')->get();
        $ann = announce::paginate(25);
        return view('/course/showannounce',['ann' => $ann]);
    }
}
