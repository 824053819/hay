<?php

namespace app\index\controller;
use think\Db;
use think\Controller;
use app\index\model\News;
use think\Request;
use think\Validate;
class Cn extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        if(!session('admin')){
            $this->assign('admin',0);

        }else{
//            var_dump(session('admin'));die;
            $this->assign('admin',session('admin'));
        }
    }
    /**
     * 网站首页
     */
    public function shouye(){
        return  $this->fetch();
    }
    /**
     * 退出登录
     */
    public function out()
    {

        //写入session起的名称
        session('admin', null);
        return $this->fetch('/cn/shouye');
    }
    //首页
    public function index()
    {
        $data = Db::table('fa_slideshow')->where('sl_ce',0)->order('sl_sort', 'desc')->select();
        $news = Db::table('fa_news')->where('ne_ce',0)->order('ne_time', 'desc')->limit('4')->select();

        $casean = Db::name('casean')->where('category_id',17)->order('weigh','desc')->limit('4')->select();
        $this->assign('data',$data);
        $this->assign('news',$news);

        foreach($casean as $k=>$v){
            $casean[$k]['cd_images'] = explode(',',$v['cd_images']);
        }
        $this->assign('casean',$casean);
        $this->assign('title','中国航空大都市研究院');
        return  $this->fetch();
    }
    //新闻详情
    public function newsxq(){
        $id =  $this->request->param('id');
        $news = Db::table('fa_news')->where('ne_id',$id)->find();
//
        Db::table('fa_news')
            ->where('ne_id', $id)
            ->setInc('ne_click');
        $news['ne_time'] = date('Y-m-d',$news['ne_time']);
         $this->assign('title',$news["ne_title"]);
        $this->assign('news',$news);
        return  $this->fetch();
    }
    //经典案例详情
    public function casean(){
        $id =  $this->request->param('id');
        $case = Db::table('fa_casean')->where('cd_id',$id)->find();
//                        dump($news);die;
        $case['cd_images'] = explode(',',$case['cd_images']);
        Db::table('fa_casean')
            ->where('cd_id', $id)
            ->setInc('cd_click');
        $this->assign('title',$case["cd_title"]);
        $this->assign('case',$case);
//        dump($case);die;
        return  $this->fetch();
    }
    //航都院介绍
    public function introduce(){
        $cate = Db::table('fa_cutform')->where('id',1)->find();
        $news = $this->recom();
        $casean = $this->mend();
//        var_dump($casean);die;
        $this->assign('title','关于我们');
        $this->assign('news',$news);
        $this->assign('casean',$casean);
        $this->assign('cate',$cate);
        return  $this->fetch();
    }
    //专家团队
    public function team(){
        $id = $this->request->param('id');
        $data = Db::name('category')->where('id',$id)->find();
        if($id==15){
            $cate = Db::table('fa_cutform')->where('id',2)->find();
        }else if($id==14){
            $cate = Db::table('fa_cutform')->where('id',3)->find();
        }else{
            $this->redirect('/indexcn');
        }
        $team = Db::table('fa_team')->where('category_id',$id)->order('weigh', 'asc')->select();
        $str='348aksdfh<>?:"{}_+/dfg/';
        foreach ($team as $k=>$v){
            $team[$k]['te_label'] = explode(',',$v['te_label']);
            $team[$k]['te_name'] = preg_replace('|[0-9a-zA-Z/]+|','',$v['te_name']);
        }
        $this->assign('title','关于我们-'.$data['name']);
        $this->assign('data',$data);//分类
        $this->assign('cate',$cate);//单页
        $this->assign('team',$team);//团队列表
        $this->assign('teamid',$id);//id
        $news = $this->recom();
        $casean = $this->mend();

//        dump($team);die;

        $this->assign('news',$news);
        $this->assign('casean',$casean);
        return  $this->fetch();
    }

    //专家信息
    public function expert(){
        $id = $this->request->param('id');
        $team = Db::table('fa_team')->where('team_id',$id)->find();
        $news = $this->recom();
        $casean = $this->mend();
        $team['te_label'] = explode(',',$team['te_label']);

        $this->assign('news',$news);
        $this->assign('casean',$casean);
        $this->assign('team',$team);
        $this->assign('title',$team["te_name"].'_航空大都市研究院');
//        dump($team);
        return  $this->fetch();
    }
    //航空大都市理论单页
    public function theory(){
        $cate = Db::table('fa_cutform')->where('id',4)->find();

        $this->assign('cate',$cate);
        $news = $this->recom();
        $casean = $this->mend();
        $this->assign('casean',$casean);
        $this->assign('news',$news);
        $this->assign('title',$cate['name']);
        return  $this->fetch();
    }

    //服务案例列表
    public function caselist(){
        $id = $this->request->param('id');

        $data = Db::name('category')->where('id',$id)->find();
        $caselist = Db::name('casean')->where('category_id',$id)->order('weigh','desc')->select();
        foreach($caselist as $k=>$v){
            $adwa = explode(',',$v['cd_images']);
            $caselist[$k]['cd_images'] = $adwa[0];
        }
        $news = $this->recom();
        $casean = $this->mend();
//        dump($caselist);die;

        $this->assign('casean',$casean);
        $this->assign('news',$news);
        $this->assign('caseid',$id);
        $this->assign('data',$data);
        $this->assign('caselist',$caselist);
        if($id==17){
            $this->assign('title',"案例_航空大都市研究院");
        }else if($id==16){
            $this->assign('title','我们的项目-服务内容');
        }else{
            $this->redirect('/indexcn');
        }

        return  $this->fetch();

    }
    //新闻动态列表
    public function newslist(){
        $newslist = Db::table('fa_news')->where('ne_ce',0)->order('ne_time', 'desc')->select();
        $news = $this->recom();
        $casean = $this->mend();

        foreach($newslist as $k=>$v){
            $newslist[$k]['ne_time'] = date('Y-m-d H:i',$v['ne_time']);
        }
        $list = Db::table('fa_news')->where('ne_ce',0)->order('ne_time', 'desc')->paginate(10)->each(function($item, $key){
            $item['ne_time'] = date('Y-m-d H:i',$item['ne_time']);
            return $item;
        });
//        dump($list);die;
        $page = $list->render();
        $count = $list->total();
//        $this->assign('list',$list);
        $this->assign('page', $page);
        $this->assign('casean',$casean);

        $this->assign('news',$news);
        $this->assign('newslist',$list);
        $this->assign('title','新闻动态');
//                dump($page);die;
        return  $this->fetch();
    }
    //足迹
    public function regions(){
        $this->assign('title','足迹');
        return  $this->fetch();
    }
    //加入我们
    public function women(){
        $this->assign('title','关于我们-联系');
        return  $this->fetch();
    }
    //  加入AIC
    public function aic(){
        $cate = Db::table('fa_cutform')->where('id',5)->find();

        $cate['lable'] = explode(',',$cate['lable']);
        $category = Db::name('category')->where('keywords','cn')->select();
//        dump($category);die;
        $this->assign('category',$category);
        $this->assign('cate',$cate);
        $this->assign('title','加入我们-介绍');
//        dump($cate);die;
        return  $this->fetch();
    }
    //搜索
    public function search(){
        $title = $this->request->param('conten');

        $news = Db::table('fa_news')->where('ne_ce',0)->where('status','neq',0)->where('ne_title','like','%'.$title.'%')->order('ne_time', 'desc')->select();
        foreach($news as $k=>$v){
            $news[$k]['ne_time'] = date('Y-m-d H:i',$v['ne_time']);
        }
        $casean = Db::name('casean')->where('category_id',17)->where('status','neq',0)->where('cd_title','like','%'.$title.'%')->order('weigh','desc')->select();
        foreach($casean as $k=>$v){
            $casean[$k]['updatetime'] = date('Y-m-d H:i',$v['updatetime']);
        }
//        dump($news);
//        dump($casean);die;
        $this->assign('title','搜索页');
        $this->assign('conten',$title);
        $this->assign('news',$news);
        $this->assign('casean',$casean);
        $newsa = $this->recom();
        $caseana = $this->mend();
//        dump($caselist);die;

        $this->assign('caseana',$caseana);
        $this->assign('newsa',$newsa);
        return  $this->fetch();
    }
    //科学文献
    public function datum(){
        $year = $this->request->param('year');
        $cate_id = $this->request->param('cate_id');
        $cate = Db::table('fa_cutform')->where('id',11)->find();
        if(!$year){
            $year = 1;
        }
        if(!$cate_id){
            $cate_id = 23;
        }
        $datum = Db::table('fa_datum')->where('da_ce',0)->where('year',$year)->where('category_id',$cate_id)->order('weigh','desc')->select();

        $date = date('Y');
        if($date==2020){
            $yer = array(2017, 2018, 2019, 2020);
        }else{
            $yer = array(
                "0"=>2017,
                "1"=>2018,
                "2"=>2019
            );
        }
//                dump($yer);die;

        $this->assign('title',$cate['name']);
        $this->assign('cate',$cate);
        $this->assign('yer',$yer);
        $this->assign('datum',$datum);
        $this->assign('year',$year);
        $this->assign('cate_id',$cate_id);


        return  $this->fetch();

    }

    //登录
    public function logon(Request $request){
            $data = $request->only(['userid','pwd']);

            $rule = [
                'userid'=>'require|length:1,25',
                'pwd'=>'require|length:6,25'
            ];
            $msg = [
                'userid.require'=>'请输入用户名或邮箱地址',
                'userid.length'=>'用户名或密码填写有误',
                'pwd.require'=>'请输入密码',
                'pwd.length'=>'密码输入的长度有误'
            ];
            $info=$this->validate($data,$rule,$msg);
            if($info!==true){
                return json([
                    'code'=>1,
                    'msg'=>$info,
                    'url'=>'/logon'
                ]);
            }

           $admin = Db::table('fa_user')->where('username',$data['userid'])->find();
            if(!$admin){
                $admin = Db::table('fa_user')->where('email',$data['userid'])->find();
                if(!$admin){

                    return json([
                    'code'=>1,
                    'msg'=>'您输入的用户名或密码有误',
                    'url'=>'/logon'
                ]);
                 }
            }
            if(password_verify($data['pwd'],$admin['password'])){
//                $lifeTime = 24*3600;
//                session_set_cookie_params($lifeTime);
                session('admin',$admin);
                return json([
                    'code'=>0,
                    'msg'=>'登录成功',
                    'data'=>$data['userid'],
                    'url'=>'http://yiliao_2.com/index'
                ]);
            }else{
                return json([
                    'code'=>1,
                    'msg'=>'您输入的密码有误',
                    'url'=>'/logon'
                ]);
            }

    }
    //注册
    public function login(Request $request){
        $data = $request->only(['email', 'uname','userid','userpwd','userpwdok']);
        if($data['userpwd'] !== $data['userpwdok']){
            return json([
                'code'=>1,
                'msg'=>'两次输入的密码不一致',
                'url'=>'/login'
            ]);
        }
        $rule = [
            'userid'  => 'require|max:25',
            'uname'  => 'require|max:10',
            'userpwd'   => 'require|length:6,25',
            'userpwdok'   => 'require',
            'email' => 'email',
        ];

        $msg = [
            'uname.require' => '名称必须',
            'userid.require' => '姓必须',
            'userpwd.require' => '密码必须',
            'userpwdok.require' => '重复密码必须',
            'email.require' => '邮箱必须',
            'uname.max'     => '姓最多不能超过10个字符',
            'userid.max'     => '名称最多不能超过25个字符',
            'userpwd.length'   => '密码必须是6到25位',

            'email'        => '邮箱格式错误',
        ];
        $info=$this->validate($data,$rule,$msg);
        if($info!==true){
            return json([
                'code'=>1,
                'msg'=>$info,
                'url'=>'/login'
            ]);
        }
        $re = Db::table('fa_user')->where('username',$data['userid'])->find();

        if($re){
            return json([
                'code'=>1,
                'msg'=>'用户名已存在',
                'url'=>'/login'
            ]);
        }
        $datatime = time();
//        var_dump($data['userpwd']);die;
        $password = password_hash($data['userpwd'],PASSWORD_DEFAULT);
        $re = Db::table('fa_user')
            ->insert(['username'=>$data['userid'],
                'nickname'=>$data['uname'],
                'password'=>$password,
                'email'=>$data['email'],
                'jointime'=>$datatime]);
//        var_dump(3333);die;
        if($re){
            $admin = Db::table('fa_user')->where('username',$data['userid'])->find();
            session('admin',$admin);
            return json([
                'code'=>0,
                'msg'=>'注册成功',
                'url'=>'/indexcn'
            ]);
        }else{
            return json([
                'code'=>1,
                'msg'=>'注册失败',
                'url'=>'/login'
            ]);
        }



    }
    //个人资料
    public function message(){
        $this->assign('title','会员中心-中国航空大都市研究院');
        return  $this->fetch();

    }
    //修改信息
    public function update(Request $request){
        $data = $request->only(['email', 'name','tname','userpwd','userpwdok']);
        if($data['userpwd'] !== $data['userpwdok']){
            return json([
                'code'=>1,
                'msg'=>'两次输入的密码不一致',
                'url'=>'/login'
            ]);
        }
        $rule = [
            'name'  => 'require|max:25',
            'tname'  => 'require|max:10',
            'userpwd'   => 'length:6,25',
            'email' => 'email',
        ];

        $msg = [
            'name.require' => '名称必须',
            'tname.require' => '姓必须',

            'userpwdok.require' => '重复密码必须',
            'email.require' => '邮箱必须',
            'name.max'     => '名称最多不能超过25个字符',
            'tname.max'     => '姓最多不能超过10个字符',
            'userpwd.length'   => '密码必须是6到25位',
            'email'        => '邮箱格式错误',
        ];
        $info=$this->validate($data,$rule,$msg);
        if($info!==true){
            return json([
                'code'=>1,
                'msg'=>$info,
                'url'=>'/login'
            ]);
        }

        $admin = session('admin');
        $row = array(
            'username'=>$data['name'],
            'nickname'=>$data['tname'],
            'password'=>password_hash($data['userpwd'],PASSWORD_DEFAULT),
            'email'=>$data['email'],
        );

        $re = Db::name('user')
            ->where('id', $admin['id'])
            ->update($row);
        if($re){
            $admin = Db::table('fa_user')->where('username',$data['name'])->find();
            session('admin',$admin);
            return json([
                'code'=>0,
                'msg'=>'修改成功',
                'url'=>'/indexcn'
            ]);
        }else{
            return json([
                'code'=>1,
                'msg'=>'修改失败',
                'url'=>'/login'
            ]);
        }
    }
    //开放职位
    public function position(){
        $id = $this->request->param('id');
        $category = Db::name('category')->where('id',$id)->find();
        $position = Db::name('position')->where('category_id',$id)->select();
        $category['description'] = explode(',',$category['description']);

        $this->assign('category',$category);
        $this->assign('position',$position);

        $this->assign('title','加入我们-AIC职位开放');
//        dump($position);die;

        return $this->fetch();
    }














    //推荐阅读新闻
    public function recom(){
        $news = Db::table('fa_news')->where('ne_ce',0)->where('status',2)->order('ne_time', 'desc')->limit('3')->select();
        return  $news;
    }
    //推荐阅读案例
    public function mend(){

        $casean = Db::name('casean')->where('category_id',17)->where('status',2)->order('weigh','desc')->limit('3')->select();
        foreach($casean as $k=>$v){
            $adwa = explode(',',$v['cd_images']);
            $casean[$k]['cd_images'] = $adwa[0];
        }
        return  $casean;
    }
}
