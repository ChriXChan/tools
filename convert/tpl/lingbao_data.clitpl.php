<?php
// ��Ҫ���ɵ��ֶ��б�Ϊ��������ȫ���ֶ�
$a1 = array(1,"star",array('id','lev','loss','attr','name','position','getway'));
$a2 = array(2,"level",array('id','lev','loss','attr','getway'));
$a3 = array(3,"skill",array('id','skill_id','skill_desc','res_id','act'));
//��N���������N��array����������˳���Ӧ�����
$array = array(
    $a1,$a2,$a3
);
buildJson($array, $xml_data);
?>
