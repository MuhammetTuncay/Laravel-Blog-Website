<?php

namespace App\Http\Controllers\Front;


use App\Http\Controllers\Front;
use App\Http\Controllers\Controller;

use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// Mail Notification
use Illuminate\Support\Facades\Notification;
use App\Notifications\Message;

// Normal düz mail
use Mail;

// Models
use App\Models\Category;
use App\Models\Article;
use App\Models\Page;
use App\Models\Contact;
use App\Models\Config;

class HomepageController extends Controller
{
    public function __construct()
    {
        if (Config::find(1)->active == 0) {
            return redirect()->to('aktif-degil')->send();
        }

        view()->share('pages',Page::where('status',1)->orderBy('order','ASC')->get());
        view()->share('categories',Category::where('status',1)->inRandomOrder()->get());
        view()->share('config', Config::find(1));
        // AppServiceProvider.php dosyasında yorum satırı yapıldı Admin de favicon kullanımı olmazken sitemizde gerçekleşmesi için yapılmıştır.
    }

    public function index()
    {
        $data['articles'] = Article::with('getCategory')->where('status',1)->whereHas('getCategory', function($query){
            $query->where('status', 1);
            })->orderBy('created_at','DESC')->paginate(10);
        $data['articles']->withPath(url('sayfa'));
        //$data['categories'] = Category::inRandomOrder()->get();
        //print_r(Category::all()); die;
        return view('front/homepage', $data);
    }

    public function single($category, $slug)
    {
        $category = Category::whereSlug($category)->first() ?? abort(403, 'Böyle bir kategori bulunmadı !!!');
        $article = Article::whereSlug($slug)->whereCategoryId($category->id)->first() ?? abort(403,'Böyle bir yazı bulunamadı !!!');
        $article->increment('hit'); // article tablosunda tiklanma okuma hit alanı bir artırır her tıklanğında
        $data['article'] = $article;
        //$data['categories'] = Category::inRandomOrder()->get();
        return view('front.single', $data);
    }

    public function category($category)
    {
        $categories = Category::whereSlug($category)->first() ?? abort(403, 'Böyle bir kategori bulunmadı !!!');

        $articles = Article::where('category_id', $categories->id)->where('status',1)->orderBy('created_at','DESC')->paginate(2);
        //$data['categories'] = Category::inRandomOrder()->get();
        return view('front.category', ['category' =>$categories, 'articles'=>$articles]);
    }

    public function page($page)
    {
        $pages = Page::whereSlug($page)->first() ?? abort('403','Böyle bir sayfa bulunamadı !!!');
        $data['page'] = $pages;
        return view('front.page',$data);
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function contactpost(Request $request)
    {
        $rules=[
            'name'=>'required|min:5',
            'email'=>'required|email',
            'topic'=>'required',
            'message'=>'required|min:10'
        ];
        $validate = Validator::make($request->post(),$rules);

        if ($validate->fails()) {
            //print_r($validate->errors()->first('message'));
            return redirect()->route('contact')->withErrors($validate)->withInput();
        }


        Mail::send([], [] ,function (){
            Notification::route('mail', 'blogsitem01@gmail.com')->notify(new Message());
        });

        /*
        Mail::send([], [] ,function ($message) use($request) {
            $message->from('blogsitem01@gmail.com', 'Blog Sistesi');
            $message->to('blogsitem01@gmail.com');
            $message->setBody(' Mesajı Gönderen: '.$request->name.'<br>
                                Mesajı Gönderen Mail:'.$request->email.'<br>
                                Mesaj Konusu: '.$request->topic.'<br>
                                Mesaj: '.$request->message.'<br><br>
                                Mesaj Gönderilme Tarihi: '.now().'', 'text/html');
            $message->subject($request->name . ' iletişimden mesaj gönderdi !');
        });
        */

        // veri tabanına kaydetme istersen yaparsın ben yapıyorum
        $contact = new Contact;
        $contact->name=$request->name;
        $contact->email=$request->email;
        $contact->topic=$request->topic;
        $contact->message=$request->message;
        $contact->save();
        return redirect()->route('contact')->with('success','İletişim mesağınız bize iletilmiştir. En kısa sürede mesajınızın yanıtı size iletilecektir.');
    }
}
