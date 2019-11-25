<?php

namespace app\index\controller;
use think\Db;
use think\Controller;
use think\Request;

//use app\index\model\News;

class En extends Controller
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
    //首页
    public function index()
    {
        $data = Db::table('fa_slideshow')->where('sl_ce',1)->order('sl_sort', 'desc')->select();
        $news = Db::table('fa_news')->where('ne_ce',1)->order('ne_time', 'desc')->limit('4')->select();

        $casean = Db::name('casean')->where('category_id',21)->order('weigh','desc')->limit('4')->select();
        $this->assign('data',$data);
        $this->assign('news',$news);

        foreach($casean as $k=>$v){
            $casean[$k]['cd_images'] = explode(',',$v['cd_images']);
        }
        $this->assign('casean',$casean);
        $this->assign('title','AIC');

//        dump($casean);die;
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
        $cate = Db::table('fa_cutform')->where('id',6)->find();
        $news = $this->recom();
        $casean = $this->mend();
//        var_dump($casean);die;
        $this->assign('title','AIC');
        $this->assign('news',$news);
        $this->assign('casean',$casean);
        $this->assign('cate',$cate);
        return  $this->fetch();
    }
    //专家团队
    public function team(){
        $id = $this->request->param('id');
        $data = Db::name('category')->where('id',$id)->find();
        if($id==18){
            $cate = Db::table('fa_cutform')->where('id',7)->find();
        }else if($id==19){
            $cate = Db::table('fa_cutform')->where('id',8)->find();
        }else{
            $this->redirect('/indexcn');
        }
        $team = Db::table('fa_team')->where('category_id',$id)->order('weigh', 'asc')->select();
        foreach ($team as $k=>$v){
            $team[$k]['te_label'] = explode(',',$v['te_label']);
        }
        $this->assign('title',$data['name']);
        $this->assign('data',$data);//分类
        $this->assign('cate',$cate);//单页
        $this->assign('team',$team);//团队列表
        $this->assign('teamid',$id);//id
        $news = $this->recom();
        $casean = $this->mend();


        $this->assign('news',$news);
        $this->assign('casean',$casean);
        return  $this->fetch();
//        dump($team);
    }

    //专家信息
    public function expert(){
        $id = $this->request->param('id');
//        dump($id);die;
        $team = Db::table('fa_team')->where('team_id',$id)->find();
        $news = $this->recom();
        $casean = $this->mend();
        $team['te_label'] = explode(',',$team['te_label']);

        $this->assign('news',$news);
        $this->assign('casean',$casean);
        $this->assign('team',$team);
        $this->assign('title',$team["te_name"].'_航空大都市研究院');
//        dump($team);die;
        return  $this->fetch();
    }
    //航空大都市理论单页
    public function theory(){
        $cate = Db::table('fa_cutform')->where('id',9)->find();
        $this->assign('cate',$cate);
        $news = $this->recom();
        $casean = $this->mend();
        $this->assign('casean',$casean);
        $this->assign('news',$news);
        $this->assign('title',$cate['name']);
        return  $this->fetch();
    }
    //足迹
    public function regions(){
        $this->assign('title','Regions');
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
        if($id==21){
            $this->assign('title',$data['name']);
        }else if($id==20){
            $this->assign('title',$data['name']);
        }else{
            $this->redirect('/indexcn');
        }

        return  $this->fetch();

    }
    //新闻动态列表
    public function newslist(){
        $newslist = Db::table('fa_news')->where('ne_ce',1)->order('ne_time', 'desc')->select();
        $news = $this->recom();
        $casean = $this->mend();

        foreach($newslist as $k=>$v){
            $newslist[$k]['ne_time'] = date('Y-m-d H:i',$v['ne_time']);
        }
        $list = Db::table('fa_news')->where('ne_ce',1)->order('ne_time', 'desc')->paginate(10)->each(function($item, $key){
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
        $this->assign('title','News');
//                dump($page);die;
        return  $this->fetch();
    }
//  加入AIC
    public function aic(){
        $cate = Db::table('fa_cutform')->where('id',10)->find();

        $cate['lable'] = explode(',',$cate['lable']);
        $category = Db::name('category')->where('keywords','en')->select();
//        dump($category);die;
        $this->assign('category',$category);
        $this->assign('cate',$cate);
        $this->assign('title','Join Us');
//        dump($cate);
        return  $this->fetch();
    }
    //加入我们
    public function women(){
        $this->assign('title','Contact');
        return  $this->fetch();
    }
    //搜索
    public function search(){
        $title = $this->request->param('conten');

        $news = Db::table('fa_news')->where('ne_ce',1)->where('status','neq',0)->where('ne_title','like','%'.$title.'%')->order('ne_time', 'desc')->select();
        foreach($news as $k=>$v){
            $news[$k]['ne_time'] = date('Y-m-d H:i',$v['ne_time']);
        }
        $casean = Db::name('casean')->where('category_id',21)->where('status','neq',0)->where('cd_title','like','%'.$title.'%')->order('weigh','desc')->select();
        foreach($casean as $k=>$v){
            $casean[$k]['updatetime'] = date('Y-m-d H:i',$v['updatetime']);
        }
//        dump($news);
//        dump($casean);die;
        $this->assign('title','Search');
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
        $cate = Db::table('fa_cutform')->where('id',12)->find();
        if(!$year){
            $year = 1;
        }
        if(!$cate_id){
            $cate_id = 26;
        }
        $datum = Db::table('fa_datum')->where('da_ce',1)->where('year',$year)->where('category_id',$cate_id)->order('weigh','desc')->select();

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

    //开放职位
    public function position(){
        $id = $this->request->param('id');
        $category = Db::name('category')->where('id',$id)->find();
        $position = Db::name('position')->where('category_id',$id)->select();
        $category['description'] = explode(',',$category['description']);

        $this->assign('category',$category);
        $this->assign('position',$position);

        $this->assign('title','加入我们-AIC职位开放');
//        dump($category);die;

        return $this->fetch();
    }








    //推荐阅读新闻
    public function recom(){
        $news = Db::table('fa_news')->where('ne_ce',1)->where('status',2)->order('ne_time', 'desc')->limit('3')->select();
        return  $news;
    }
    //推荐阅读案例
    public function mend(){

        $casean = Db::name('casean')->where('category_id',21)->where('status',2)->order('weigh','desc')->limit('3')->select();
        foreach($casean as $k=>$v){
            $adwa = explode(',',$v['cd_images']);
            $casean[$k]['cd_images'] = $adwa[0];
        }
        return  $casean;
    }
}
