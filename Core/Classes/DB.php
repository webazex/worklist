<?php

namespace Core\Classes;
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once($_SERVER['DOCUMENT_ROOT'] . '/Core/autoload.php');


class DB
{
    function __construct()
    {
        self::db_set_connect();
    }

    function __destruct()
    {
        self::db_close();
    }

    static function db_connect()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new \mysqli('localhost:3307', 'webazex', 'Webazex*01!', 'task');
//         $mysqli = new \mysqli('134.249.158.47', 'root', '', 'task');
        return $mysqli;
    }

    static function db_status()
    {
        if (mysqli_connect_errno()):
            return false;
        else:
            return true;
        endif;
    }

    static function db_set_connect()
    {
        $status = self::db_status();
        if ($status == false):
            self::db_connect();
        endif;
    }

    static function db_close()
    {
        self::db_connect()->close();
    }

    static function db_read_all_table($table_name)
    {
        $status = self::db_status();
        if ($status == false):
            echo "fail";
            throw new \Exception('Немає з’єднання з базою данних!');
        else:
            $bd = self::db_connect();
            $bd->real_query("SELECT * FROM " . "`" . $table_name . "`");
            if ($return = $bd->use_result()):
                $arRezult = array();
                while ($row = $return->fetch_row()):
                    array_push($arRezult, $row);
                endwhile;
                $return->close();
                return $arRezult;
            endif;
        endif;
    }

    static function db_get_row_in_table($table_name, $id)
    {
        $status = self::db_status();
        if ($status == false):
            throw new \Exception('Немає з’єднання з базою данних!');
            return false;
        else:
            $bd = self::db_connect();
            $bd->real_query("SELECT * FROM " . "`" . $table_name . "` WHERE `id`=" . $id);
            if ($return = $bd->use_result()):
                $arRezult = array();
                while ($row = $return->fetch_row()):
                    array_push($arRezult, $row);
                endwhile;
                $return->close();
                return print_r($arRezult);
            endif;
        endif;
    }

    static function db_get_custom_fields_row_in_table($table_name, $fields, $id)
    {
        $status = self::db_status();
        if ($status == false):
            throw new \Exception('Немає з’єднання з базою данних!');
        else:
            $bd = self::db_connect();
            $bd->real_query("SELECT " . $fields . " FROM " . "`" . $table_name . "` WHERE `id`=" . $id);
            if ($return = $bd->use_result()):
                $arRezult = array();
                while ($row = $return->fetch_row()):
                    array_push($arRezult, $row);
                endwhile;
                $return->close();
            endif;
        endif;
    }

    static function db_get_custom_fields_with_filter($table_name, $fields, $filter, $filterValue)
    {
        $status = self::db_status();
        if ($status == false):
            throw new \Exception('Немає з’єднання з базою данних!');
        else:
            $bd = self::db_connect();
            $bd->real_query("SELECT " . $fields . " FROM " . "`" . $table_name . "` WHERE `" . $filter . "`=" . $filterValue);
            if ($return = $bd->use_result()):
                $arRezult = array();
                while ($row = $return->fetch_row()):
                    array_push($arRezult, $row);
                endwhile;
                $return->close();
                return $arRezult;
            else:
                return false;
            endif;
        endif;
    }

    static function db_get_custom_fields_with_filters($relation)
    {
        $status = self::db_status();
        if ($status == false):
            throw new \Exception('Немає з’єднання з базою данних!');
        else:
            $bd = self::db_connect();
//            $bd->real_query("SELECT " . $fields . " FROM " . "`" . $table_name . "` WHERE `" . $query);
            $bd->real_query("SELECT `id`, `fio` FROM `users` WHERE `role` = 0 " . $relation . " `role` = 1");
            if ($return = $bd->use_result()):
                $arRezult = array();
                while ($row = $return->fetch_row()):
                    array_push($arRezult, $row);
                endwhile;
                $return->close();
                return $arRezult;
            else:
                return false;
            endif;
        endif;
    }

    static function db_add_in_table($table_name, $arr)
    {
        $status = self::db_status();
        if ($status == false):
            throw new \Exception('Немає з’єднання з базою данних!');
        else:
            $bd = self::db_connect();
            $bd->set_charset("utf8");
            $table_name = $bd->real_escape_string($table_name);
            $arfields = array();
            $arvalues = array();
            foreach ($arr as $f => $v):
                $f = "`" . $f . "`";
                array_push($arfields, $f);
                $v = "'" . $v . "'";
                array_push($arvalues, $v);
            endforeach;
            $fields = implode(",", $arfields);
//            echo $fields;
            $values = implode(", ", $arvalues);
//            echo $values;
//            die();
            $table_name = $bd->real_escape_string($table_name);
//            $query = $bd->real_query("INSERT INTO `tasks` (`id`, `letter_num-moz`, `letter_num-ascod`, `letter_num-departament`, `title`, `performers_departament`, `description`, `date_start`, `date_end`, `sender`, `recipient`, `performers`, `status`) VALUES (NULL, '45435435', '3452354234', '234', 'fcvfdgdsf', 'gdfs asdfa aseaf sdz', 'dsfdszf ', '2020-06-17', '2020-06-26', 'sadfas', 'fdsafs', '\"2\" "19" "20"', 'dfdfgd');")
            $query = $bd->real_query("INSERT INTO " . "`" . $table_name . "` (" . $fields . ") VALUES (" . $values . ")");
            if ($query == false):
                $er = $bd->error;
                $bd->close();
                echo $er;
            else:
                $bd->close();
                return true;
            endif;
        endif;
    }

    static function db_select_in_table($table_name, $fields)
    {
        $status = self::db_status();
        if ($status == false):
            throw new \Exception('Немає з’єднання з базою данних!');
        else:
            $bd = self::db_connect();
            $bd->real_query("SELECT " . $fields . " FROM " . "`" . $table_name);
            if ($return = $bd->use_result()):
                $arRezult = array();
                while ($row = $return->fetch_row()):
                    array_push($arRezult, $row);
                endwhile;
                $return->close();
                return $arRezult;
            endif;
        endif;
    }

    static function db_update_in_table($table_name, $arr, $id)
    {
        $status = self::db_status();
        if ($status == false):
            throw new \Exception('Немає з’єднання з базою данних!');
        else:
            $bd = self::db_connect();
            $ardata = array();
            foreach ($arr as $k => $v):
                $k = '`' . $k . '`';
                $v = "'" . $v . "'";
                $string = $k . " = " . $v;
                array_push($ardata, $string);
            endforeach;
            $data = implode(", ", $ardata);
            $sql = "UPDATE `" . $table_name . "` SET " . $data . " WHERE `" . $table_name . "`.`id` = " . $id . "";
            $query = $bd->real_query($sql);
            if ($query == false):
                $er = $bd->error;
                $bd->close();
                echo $er;
                echo "false";
            else:
                $bd->close();
                return true;
            endif;
        endif;
    }

    static function db_delete_row_in_table($table_name, $id)
    {
        $status = self::db_status();
        if ($status == false):
            throw new \Exception('Немає з’єднання з базою данних!');
        else:
            $bd = self::db_connect();
            $sql = "DELETE FROM `" . $table_name . "` WHERE `" . $table_name . "`.`id` = " . $id;
            $query = $bd->real_query($sql);
            if ($query == false):
                $er = $bd->error;
                $bd->close();
                echo $er;
                echo "false";
            else:
                $bd->close();
                return true;
            endif;
        endif;
    }

    static function db_search_in_user_table($search, $switch, $role = null)
    {
        $status = self::db_status();
        if ($status == false):
            throw new \Exception('Немає з’єднання з базою данних!');
        else:
            $bd = self::db_connect();
            if ($switch == 0):
                $sql = "SELECT * FROM users WHERE login LIKE '" . $search . "'";
            elseif ($switch == 1):
                $sql = "SELECT * FROM users WHERE login LIKE '" . $search . "' AND role LIKE '" . $role . "'";
            endif;
            $bd->real_query($sql);
            if ($return = $bd->use_result()):
                $arRezult = array();
                while ($row = $return->fetch_row()):
                    array_push($arRezult, $row);
                endwhile;
                $return->close();
                return $arRezult;
            endif;
        endif;
    }

    static function db_select_in_user_table($l, $p, $r)
    {
        $status = self::db_status();
        if ($status == false):
            throw new \Exception('Немає з’єднання з базою данних!');
        else:
            $bd = self::db_connect();
            $l = mysqli_real_escape_string($bd, $l);
            $p = mysqli_real_escape_string($bd, $p);
            $r = mysqli_real_escape_string($bd, $r);
            $bd->real_query("SELECT `id`, `fio`, `login`, `role` FROM `users` WHERE `login` = '" . $l . "' AND `passw` = '" . $p . "' AND `role` = '" . $r . "' ");
            if ($return = $bd->use_result()):
                $arRezult = array();
                while ($row = $return->fetch_row()):
                    array_push($arRezult, $row);
                endwhile;
                $return->close();
                return $arRezult;
            endif;
        endif;
    }

    static function db_get_rows_for_user($like)
    {
        $status = self::db_status();
        if ($status == false):
            throw new \Exception('Немає з’єднання з базою данних!');
        else:
            $bd = self::db_connect();
            $l = mysqli_real_escape_string($bd, $like);
            $s = '\"' . $l . '\"';
            $bd->real_query("SELECT * FROM `tasks` WHERE `performers` REGEXP '" . $s . "'");
            if ($return = $bd->use_result()):
                $arRezult = array();
                while ($row = $return->fetch_row()):
                    array_push($arRezult, $row);
                endwhile;
                $return->close();
                return $arRezult;
            endif;
        endif;
    }


    static function db_get_users($ids)
    {
        $status = self::db_status();
        if ($status == false):
            throw new \Exception('Немає з’єднання з базою данних!');
        else:
            $bd = self::db_connect();
            $arRezult = array();
            foreach ($ids as $id):
                $bd->real_query("SELECT `fio` FROM `users` WHERE `id` LIKE  " . $id);
                $ret = $bd->use_result();
                while ($row = $ret->fetch_row()):
                    array_push($arRezult, $row[0]);
                endwhile;
            endforeach;
            return $arRezult;
        endif;
    }

//    ====search-start
    static function db_search_interval_date($date_start, $date_limit)
    {
        $status = self::db_status();
        if ($status == false):
            throw new \Exception('Немає з’єднання з базою данних!');
        else:
            $arRezult = array();
            $bd = self::db_connect();
            $bd->real_query("SELECT * FROM `tasks` WHERE `date_start` >= '" . $date_start . "' AND `date_start` <= '" . $date_limit . "'");
            $ret = $bd->use_result();
            while ($row = $ret->fetch_row()):
                array_push($arRezult, $row);
            endwhile;
        endif;
        return $arRezult;
    }

    static function db_search_start_interval_date($date_start)
    {
        $status = self::db_status();
        if ($status == false):
            throw new \Exception('Немає з’єднання з базою данних!');
        else:
            $arRezult = array();
            $bd = self::db_connect();
            $bd->real_query("SELECT * FROM `tasks` WHERE `date_start` >= '" . $date_start . "'");
            $ret = $bd->use_result();
            while ($row = $ret->fetch_row()):
                array_push($arRezult, $row);
            endwhile;
        endif;
        return $arRezult;
    }

    static function db_search_end_interval_date($date_limit)
    {
        $status = self::db_status();
        if ($status == false):
            throw new \Exception('Немає з’єднання з базою данних!');
        else:
            $arRezult = array();
            $bd = self::db_connect();
            $bd->real_query("SELECT * FROM `tasks` WHERE `date_start` <= '" . $date_limit . "'");
            $ret = $bd->use_result();
            while ($row = $ret->fetch_row()):
                array_push($arRezult, $row);
            endwhile;
        endif;
        return $arRezult;
    }
}
//=========end=search==================
//поиск от и до включительно SELECT * FROM `tasks` WHERE `date_start` >= '2020-06-20' AND `date_start` <= '2020-06-26'
// по возрастанию SELECT * FROM `tasks` ORDER BY `tasks`.`letter_num-moz` ASC
//по убыванию SELECT * FROM `tasks` ORDER BY `tasks`.`letter_num-moz` DESC
// ====for=test====
if (!empty($_POST)):
    $data = new DB;
//    $f = "`code_role`, `role`";
//    $filter = "role";
//    $p = 'Начальник отдела';
//    $filterV = "'" . $p . "'";
//    $a = $data::db_get_custom_fields_with_filter('roles', $f, $filter, $filterV);
//$role = "'Адміністратор'";
//    $r = $data::db_get_custom_fields_with_filter('roles', 'code_role', 'role', $role);
//    var_dump($r);
//$q = $data::db_select_in_user_table('webazex', '12345', 3);
//$ar = array(20, 19, 2);
//    $q = $data::db_get_users($ar);
//$q = $data::db_search_end_interval_date('2020-06-20');
//echo('<pre>');
//print_r($q);
//echo('</pre>');

    //$this_data = date('Y') . '-' . date('m') . '-' . date('d');

//    $ar2 = array(
//        'test1' => 'delit my2',
//        'title' => '22220',
//        'text' => '52',
//        'qqq' => "2",
//        'aaa' => "aAa2"
//
//    );
    // $data::db_add_in_table('users', $ar2);
//    var_dump($data::db_status());

// $data::db_update_in_table('test', $ar2, 2);
//    $data::db_get_row_in_table('test', 2);
//$data::db_select_in_table();
// $data = new DB;
// $data::db_read_table('test');
// $data->db_read_table('users');
// $f = "`role`";
// $a = $data::db_select_in_table('roles', $f);
// $ar = array();
// foreach ($a as $item):
//   array_push($ar, $item[0]);
// endforeach;
// $str = implode(", ", $ar);
// echo $str;
//var_dump($data::db_get_custom_fields_with_filters('users', 'fio', "`role` = 1 OR `role = 0`"));
// $data::db_delete_row_in_table('test', 4);
//else:
    // return "false";
    //    var_dump($a);
//    $q = $data::db_get_rows_for_user($_POST['test']);
//    print_r($q);
//$q = $data::db_get_users($arr = array(1, 2, 3, 19, 21, 22));
//print_r($q);
//$q = $data::db_search_end_interval_date('2020-06-20');
//print_r($q);
endif;
