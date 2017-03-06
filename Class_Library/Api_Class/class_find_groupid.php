<?php

if (!class_exists('Connection_Communication')) {
    require_once('class_connect_db_Communication.php');
}

class FindGroup {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function groupBaseofUid($clientid, $uid) {
        $this->idclient = $clientid;

        try {
            $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $uid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows) {
                /*                 * *************************** fetch all demography parameter start ******************** */
                $qry = "select demoGraphy from Tbl_ClientGroupDemoGraphy where clientId=:cli";
                $stmt = $this->DB->prepare($qry);
                $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt->execute();
                $rows11 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $democount = count($rows11);
                $k = "";
                for ($i = 0; $i < $democount; $i++) {
                    $val = $rows11[$i]['demoGraphy'];
                    $demographyname = $rows[0][$val];
                    $k .= "'$demographyname',";
                }
                //  echo "demo parameter :-".$k."<br/>";
                /*                 * *************************** fetch all demography parameter End ******************** */

                $variable1 = rtrim($k, ',');
                $variable = $variable1 . ",'All'";
                // echo "variable ".$variable."<br>";
                $unique_group = array();
                /*                 * ********************************************************************* */
                $group = array();
                $query4 = "select * from Tbl_ClientGroupDemoParam where columnName IN(select demoGraphy from Tbl_ClientGroupDemoGraphy where clientId=:cli) and columnValue IN($variable) and clientId = :cli group by groupId";
                // echo "query of group ->".$query4."<br/>";
                $stmt4 = $this->DB->prepare($query4);
                $stmt4->bindParam(':cli', $this->idclient, PDO::PARAM_STR);

                $stmt4->execute();
                $rows4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                /*    echo "<pre>";
                  print_r($rows4);
                  echo "</pre>"; */
                foreach ($rows4 as $sd) {
                    array_push($unique_group, $sd['groupId']);
                }
                /*                 * ************************************************************************** */
                /* echo "unique group ";
                  echo "<pre>";
                  // print_r($unique_group);
                  echo "</pre>"; */

                /*                 * ************************************************************ */
            }

            /*             * *********************************fetch user on the base of group demo grphy paramenter****************** */

            $count = count($unique_group);
            //echo "count of unique group:-".$count."<br/>";
            $allrows = array();
            $allgroup = array();
            for ($t = 0; $t < $count; $t++) {
                $groupid = $unique_group[$t];
                //  echo "group id:-".$groupid."<br/>";
                /*                 * **************************************************************** */
                try {
                    $query5 = "select distinct(columnName) from Tbl_ClientGroupDemoParam where groupId=:gid and clientId=:cid1";

                    $stmt5 = $this->DB->prepare($query5);
                    $stmt5->bindParam(':gid', $groupid, PDO::PARAM_STR);
                    $stmt5->bindParam(':cid1', $this->idclient, PDO::PARAM_STR);
                    if ($stmt5->execute()) {

                        $rows = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                        $count1 = count($rows);
                        $response1 = array();
                        for ($i = 0; $i < $count1; $i++) {
                            // echo $rows[$i]['columnName'];
                            $query = "select ColumnValue from Tbl_ClientGroupDemoParam where columnName=:cname and groupId=:gid1";

                            $stmt = $this->DB->prepare($query);
                            $stmt->bindParam(':gid1', $groupid, PDO::PARAM_STR);
                            $stmt->bindParam(':cname', $rows[$i]['columnName'], PDO::PARAM_STR);
                            $stmt->execute();

                            $rows1 = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
                            $posts["columnName"] = $rows[$i]['columnName'];
                            $posts["distictValuesWithinColumn"] = $rows1;

                            array_push($response1, $posts);
                        }
                    }
                    /*  echo "<pre>";
                      print_r($response);
                      echo "</pre>"; */
                    $countrow = count($response1);
//echo "total count of group parameter : - ".$countrow."</br>";
                    $substring = "";
                    for ($j = 0; $j < $countrow; $j++) {
                        $columnname = $response1[$j]['columnName'];
                        // echo "column name  : - ".$columnname."<br/>";
                        $columnvalue = count($response1[$j]['distictValuesWithinColumn']);
                        //echo "no of value in column  : - ".$columnvalue."<br/>";
                        $su = "";
                        for ($k = 0; $k < $columnvalue; $k++) {
                            if ($response1[$j]['distictValuesWithinColumn'][$k] != 'All') {
                                $su .= "'" . $response1[$j]['distictValuesWithinColumn'][$k] . "'" . ",";
                            } else {
                                $su .= "";
                            }
                        }

// echo "value of half sub string ".$su."<br/>";
                        if ($su != "") {
                            // $string = str_replace(' ', '', $su);
                            // echo "value of string = : ".$string."<br/>";
                            $su1 = rtrim($su, ',');
// echo "series of column value  : - ".$su1."<br/>";
                            $substring .= $columnname . " IN(" . $su1 . ")" . " and ";
                            // echo $substring."<br/>";
                        } else {
                            $substring .= "";
                        }
                    }
                    $finalstring = $substring . " clientid = '" . $this->idclient . "'";

//echo "final string : - ".$finalstring."<br/>";

                    try {
                        $qq = "select firstName,employeeId,clientId from Tbl_EmployeeDetails_Master where " . $finalstring;
                        // $qq1 = "select firstName,emailId from Tbl_EmployeeDetails_Master where ".$finalstring;
                        //echo $qq."<br/>";
                        $stmt2 = $this->DB->prepare($qq);

                        if ($stmt2->execute()) {

                            $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                            /*  echo "<pre>";
                              // print_r($rows2);
                              echo "</pre>"; */

                            $rowcount = count($rows2);
                            for ($r = 0; $r < $rowcount; $r++) {
                                if ($rows2[$r]['employeeId'] == $uid) {
                                    array_push($allgroup, $groupid);
                                }
                            }


                            foreach ($rows2 as $row5) {
                                array_push($allrows, $row5['employeeId']);
                            }
                        }
                    } catch (PDOException $e) {
                        echo $e;
                    }
                    //echo "--------------------------------------<br/>";
                }

                /*                 * ***************************************** */ catch (PDOException $ex) {
                    $value = $ex;
                    echo $value;
                }
            }

            // $value = json_encode($allrows);

            /*             * *********************************************************************************************** */
            if (count($allgroup) > 0) {
                $res['success'] = 1;
                $res['msg'] = "data found";
                $res['groups'] = $allgroup;

                return json_encode($res);
            } else {
                $res['success'] = 0;
                $res['msg'] = "no group found";

                return json_encode($res);
            }
        } catch (PDOException $ex) {
            $value = $ex;
            echo $value;
        }
    }

}

?>
