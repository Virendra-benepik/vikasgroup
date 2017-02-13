<?php

if (!class_exists('Connection_Communication')) {
    include_once('class_connect_db_Communication.php');
}

class Album {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function compress_image($source_url, $destination_url, $quality) {

        $imagevalue = filesize($source_url);
        $valueimage = $imagevalue / 1024;

        if ($valueimage > 40) {
            $info = getimagesize($source_url);

            if ($info['mime'] == 'image/jpeg')
                $image = imagecreatefromjpeg($source_url);
            elseif ($info['mime'] == 'image/gif')
                $image = imagecreatefromgif($source_url);
            elseif ($info['mime'] == 'image/png')
                $image = imagecreatefrompng($source_url);

            //save it
            imagejpeg($image, $destination_url, $quality);

            //return destination file url
            return $destination_url;
        }
        else {
            move_uploaded_file($source_url, $destination_url);
            return true;
        }
    }

    public $client;
    public $albumid;
    public $atitle;
    public $description;
    public $imgpath;
    public $pdate;
    public $author;
    public $by;
    public $flag;
    public $email;
    public $teaser;
    public $like;
    public $comment;

    function maxId() {
        try {
            $max = "select max(autoId) from Tbl_C_AlbumDetails";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $albumid = "Album-" . $m_id1;

                return $albumid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function createAlbum($cid, $aid, $atitle, $date, $by) {
        $this->client = $cid;
        $this->albumid = $aid;
        $this->atitle = $atitle;
        //$this->description = $adesc;
        $this->author = $by;
        $this->adate = $date;

        try {
            $query = "insert into Tbl_C_AlbumDetails(clientId,albumId,title,createdby,createdDate)
            values(:cid,:aid,:title,:cb,:cd)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':aid', $this->albumid, PDO::PARAM_STR);
            $stmt->bindParam(':title', $this->atitle, PDO::PARAM_STR);
            // $stmt->bindParam(':des', $this->description, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $this->adate, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $this->author, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $ft = 'True';
                return $ft;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $caption;

    function saveImage($albumid, $image, $title, $thumbImgName, $caption) {
        $this->albumid = $albumid;
        $this->title = $title;
        $this->imgpath = $image;
        $this->caption = $caption;

        try {
            $query = "insert into Tbl_C_AlbumImage(albumId,imgName,thumbImgName,imageCaption,title) values(:aid,:img,:thumbImgName,:imageCaption,:title)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':aid', $this->albumid, PDO::PARAM_STR);
            $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindParam(':img', $this->imgpath, PDO::PARAM_STR);
            $stmt->bindParam(':thumbImgName', $thumbImgName, PDO::PARAM_STR);
            $stmt->bindParam(':imageCaption', $this->caption, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $ft = 'True';
                return $ft;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ************************ get album Details ******************* */

    function getAlbum($cid, $uuid, $device = '') {

        $this->client = $cid;
        $this->author = $uuid;
        try {
            $server_name = ($device == '') ? dirname(SITE_URL) . '/' : SITE;
            $query = "select ad.*,DATE_FORMAT(ad.createdDate,'%d %b %Y %h:%i %p') as createdDate,concat('" . $server_name . "',ai.imgName) as image , concat(count(ai.albumId),' Photos') as totalimage from Tbl_C_AlbumDetails as ad join Tbl_C_AlbumImage as ai on ad.albumId = ai.albumId where ad.clientId =:cid group by ad.albumId order by autoId desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);

            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($rows) > 0) {
                $response["success"] = 1;
                $response["message"] = "Displaying post details";
                $response["posts"] = $rows;
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "No Albums Available";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getAlbumImage($albumid, $device = '') {
        $this->albumid = $albumid;
        try {
            $server_name = ($device == '') ? dirname(SITE_URL) . '/' : SITE;
            $query = "select *, if(thumbImgName IS NULL or thumbImgName ='', concat('" . $server_name . "',imgName), concat('" . $server_name . "',thumbImgName)) as imgName  from Tbl_C_AlbumImage where albumId =:aid order by autoId desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':aid', $this->albumid, PDO::PARAM_STR);

            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //   print_r($rows);
            if ($rows > 0) {
                $response["success"] = 1;
                $response["message"] = "Displaying post details";
                $response["posts"] = $rows;
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "No post details Available";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function albumSentToGroup($clientId, $albumId, $GroupId) {
        $this->client = $clientId;
        $this->albumId = $albumId;
        $this->groupid = $GroupId;
        date_default_timezone_set('Asia/Calcutta');
        $today = date("Y-m-d H:i:s");
        $flag = 11;
        try {
            $query = "insert into Tbl_Analytic_AlbumSentToGroup(clientId,albumId,groupId,sentDate,flagType)values(:cid,:aid,:gid,:today,:flag)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':aid', $this->albumId, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $this->groupid, PDO::PARAM_STR);
            $stmt->bindParam(':today', $today, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ******************* get album image details ************************************** */

    function getalbumimagedetails($albumid, $imageid) {

        try {
            $query = "select * from Tbl_C_AlbumImage where albumId = :albumid AND autoId = :imgid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':albumid', $albumid, PDO::PARAM_STR);
            $stmt->bindParam(':imgid', $imageid, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();
        $response["success"] = 1;
        $response["message"] = "Displaying Album Image details";
        $response["posts"] = array();

        if ($rows) {
            for ($i = 0; $i < count($rows); $i++) {
                $post["post_title"] = $rows[$i]["title"];
                $post["post_img"] = $rows[$i]["imgName"];
                array_push($response["posts"], $post);
            }
            return json_encode($response);
        }
    }

    function getAllAlbumImageDetails($albumid, $clientid = '', $device = '') {
        $this->albumid = $albumid;
        $status = 1;
        try {
            $server_name = ($device == '') ? dirname(SITE_URL) . '/' : SITE;


            $query = "select *, if(thumbImgName IS NULL or thumbImgName='',concat('" . $server_name . "',imgName),concat('" . $server_name . "',thumbImgName)) as imgName  from Tbl_C_AlbumImage where albumId =:aid order by autoId desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':aid', $this->albumid, PDO::PARAM_STR);

            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

//            print_r($rows);die;

            if ($rows > 0) {
                $response["success"] = 1;
                $response["message"] = "Displaying post details";
                $response["posts"] = array();

                for ($i = 0; $i < count($rows); $i++) {
                    $post = array();

                    $post["autoId"] = $rows[$i]["autoId"];
                    $post["albumId"] = $rows[$i]["albumId"];
                    $post["imgName"] = $rows[$i]["imgName"];
                    $post["title"] = $rows[$i]["title"];
                    $post["imageCaption"] = $rows[$i]["imageCaption"];

                    $imgautoid = $rows[$i]["autoId"];
                    $albid = $rows[$i]["albumId"];

                    // $objLike = new Like;
                    // $likes_content = $objLike->getTotalLikeANDcomment($clientid,$post['albumId'],$imgautoid);
                    /*                     * *************************** count total like ****************************** */
                    $query = "select count(imageId) as total_likes from Tbl_Analytic_AlbumLike where albumId =:albumid AND imageId = :imgid and status = :status";
                    $stmt = $this->DB->prepare($query);

                    $stmt->bindParam(':albumid', $albid, PDO::PARAM_STR);
                    $stmt->bindParam(':imgid', $imgautoid, PDO::PARAM_INT);
                    $stmt->bindParam(':status', $status, PDO::PARAM_INT);

                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);


                    include_once('Api_Class/class_albumLike.php');
                    include_once('Api_Class/class_comment_album.php');

                    $objLike = new Like;

                    $likes_content = $objLike->getTotalLikeANDcomment($clientid, $post['albumId'], $imgautoid);

                    $objComment = new Comment;
                    $comment_content = $objComment->Comment_display($clientid, $post['albumId'], $imgautoid);

//                    $post["likeDate"] = $userdetailsrows["likeDate"];
                    $post["total_likes"] = $row["total_likes"];
                    $post["total_comments"] = (!empty($comment_content["total_comments"])) ? $comment_content["total_comments"] : "0";

                    $post["likes"] = ($likes_content['Success'] == 1) ? $likes_content['Posts'] : "";
                    $post["comments"] = ($comment_content['Success'] == 1) ? $comment_content['Posts'] : "";
//                    print_r($post);die;
//                    $post["likes"] = ($row["total_likes"] == 0) ? "" : $likes_content['Posts'];
//                    $post["comments"] = ($post["total_comments"] == 0) ? "" : $comment_content['Posts'];


                    array_push($response["posts"], $post);
//                    print_r($response);die;
                }
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "No post details Available";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * *************************** end get album image details ***************************** */

    /*     * ****************** get album image like *************************************** */

    function getAlbumImagelike($albumid, $imageid) {

        try {
            $query1 = "SELECT *,DATE_FORMAT(createdDate	,'%d %b %Y %h:%i %p') as createdDate FROM Tbl_Analytic_AlbumLike WHERE albumId = :aid AND imageId = :imgid";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':aid', $albumid, PDO::PARAM_STR);
            $stmt1->bindParam(':imgid', $imageid, PDO::PARAM_STR);
            $stmt1->execute();
            $rows = $stmt1->fetchAll();
            $count = count($rows);
            $response["posts"] = array();
            $response["total_like"] = $count;

            if ($rows) {

                $forimage = SITE;

                $response["success"] = 1;
                $response["message"] = "likes available";

                $i = 0;
                while ($i < count($rows)) {
                    $post = array();

                    $post["albumId"] = $rows[$i]["albumId"];
                    $post["imageId"] = $rows[$i]["imageId"];
                    $post["userId"] = $rows[$i]["userId"];
                    $mailid = $rows[$i]["userId"];

                    $query2 = "SELECT Tbl_EmployeeDetails_Master.*, Tbl_EmployeePersonalDetails.* FROM Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId WHERE Tbl_EmployeeDetails_Master.employeeId =:maid";

                    $stmt2 = $this->DB->prepare($query2);
                    $stmt2->bindParam(':maid', $mailid, PDO::PARAM_STR);
                    $stmt2->execute();
                    $row = $stmt2->fetch(PDO::FETCH_ASSOC);

                    //echo'<pre>';print_r($row);
                    $post["firstname"] = $row["firstName"];
                    $post["lastname"] = $row["lastName"];
                    $post["designation"] = $row["designation"];
                    // $post["userimage"] = ($row["userImage"]==''?'':$forimage . $row["userImage"]);

                    $post["userimage"] = ($row["linkedIn"] == '1' ? $row["userImage"] : ($row["userImage"] == '' ? '' : $forimage . $row["userImage"]));
                    $post["cdate"] = $rows[$i]["createdDate"];
                    //$posts[] = $post;
                    //echo'<pre>';print_r($posts);

                    array_push($response["posts"], $post);
                    $i++;
                }
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "There is no Like for this post";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ******************* end album image like *************************************** */

    /*     * ****************************** album image comment ********************************* */

    function getAlbumImageComment($albumid, $imageid) {
        $status = 1;
        try {
            $query1 = "SELECT *,DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as commentDate FROM Tbl_Analytic_AlbumComment WHERE albumId = :albumid and imageId = :imgid and status = :status";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':albumid', $albumid, PDO::PARAM_STR);
            $stmt1->bindParam(':imgid', $imageid, PDO::PARAM_STR);
            $stmt1->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt1->execute();
            $rows = $stmt1->fetchAll();

            $response["posts"] = array();


            if ($rows) {
                $forimage = SITE;

                $response["success"] = 1;
                $response["message"] = "comments available";

                for ($i = 0; $i < count($rows); $i++) {
                    $post = array();

                    $post["comment_id"] = $rows[$i]["commentId"];
                    $post["albumid"] = $rows[$i]["albumId"];
                    $post["imageId"] = $rows[$i]["imageId"];
                    $post["content"] = $rows[$i]["comments"];
                    $post["commentby"] = $rows[$i]["userId"];
                    $mailid = $rows[$i]["userId"];

                    $query2 = "SELECT Tbl_EmployeeDetails_Master.*, Tbl_EmployeePersonalDetails.* FROM Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId WHERE Tbl_EmployeeDetails_Master.employeeId =:maid";
                    $stmt2 = $this->DB->prepare($query2);
                    $stmt2->bindParam(':maid', $mailid, PDO::PARAM_STR);
                    $stmt2->execute();
                    $row = $stmt2->fetchAll();

                    $post["firstname"] = $row[0]["firstName"];
                    $post["lastname"] = $row[0]["lastName"];
                    $post["designation"] = $row[0]["designation"];
                    // $post["userimage"] = ($row[0]["userImage"]==''?'':$forimage . $row[0]["userImage"]);

                    $post["userimage"] = ($row[0]["linkedIn"] == '1' ? $row[0]["userImage"] : ($row[0]["userImage"] == '' ? '' : $forimage . $row[0]["userImage"]));

                    $post["cdate"] = $rows[$i]["createdDate"];


                    array_push($response["posts"], $post);
                }

                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "There is no comments for this post";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ********************** end album image comment *************************************** */
}

?>