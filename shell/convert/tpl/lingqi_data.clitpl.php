<?php
// ��Ҫ���ɵ��ֶ��б�Ϊ��������ȫ���ֶ�
$a1 = array(1,"base",array('id','cond','cond_level','skill_id','res_id','skill_desc','has_ad'));
$a2 = array(2,"upgrade",array('unique_id','id','stage','star','is_update','max_bless','succ','bless_range','loss','attr','skill_id'));
$a3 = array(3,"3",array('id','loss','next_id','pos','type','last_id','score'));
$a4 = array(4,"4",array('num','lingqi_id','pos','step','level','attr','loss'));
$a5 = array(5,"5",array('num','pos','name','getway','desc','type'));
//��N���������N��array����������˳���Ӧ�����
$array = array(
    $a1,$a2,$a3,$a4,$a5
);
buildJson($array, $xml_data);
?>
