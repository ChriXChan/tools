<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"base",array('id','name','type','type_sub','grade','conds','total_time','maps','enter_point','first','pass','drop','mop_gold_loss','boss','mon','show','desc'));//基础数据
$a2 = array(5,"coin_appraise",array('score','min','max','rate'));//铜钱副本评分数据
$a3 = array(6,"const",array('label','value'));//副本常量配置数据
$a4 = array(8,"tower",array('cell','maps','mon','first','pass','fc','desc','title'));//爬塔层数数据
$a5 = array(10,"multidug",array('id','cell','maps','first','mon','fc','pos','icon'));//多人副本
$a6 = array(11,"multidugstar",array('id','cell','one_time','two_time','three_time'));//多人副本星级
$a7 = array(12,"multiduggift",array('id','star','gain'));//多人副本星级累计奖励
$a8 = array(13,"pressureceil",array('chapter','ceil','id','gain1','gain2','gain3','time','hp'));//压力副本关卡
$a9 = array(14,"pressurebox",array('chapter','gain','star'));//压力副本宝箱
$a10 = array(15,"pressurevip",array('level','times'));//压力vip增加体力购买次数
$a11 = array(16,"pressuretimes",array('times','gold'));//压力vip购买次数对应消耗元宝
$a12 = array(17,"asura",array('cell','time','hp','boxbonus','res','show','gain','desc'));//修罗洞
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1
    ,$a2
    ,$a3
    ,$a4
    ,$a5
    ,$a6
    ,$a7
    ,$a8
    ,$a9
    ,$a10
    ,$a11
    ,$a12
);
buildJson($array, $xml_data);
?>

