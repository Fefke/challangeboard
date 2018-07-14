<?php
//Intro: http://www.kavoir.com/backyard/showthread.php?28-Use-PHP-to-generate-edit-and-update-htpasswd-and-htgroup-authentication-files
/*
$groups = array(
    'group' = array('user', 'user'),
);
*/

############### Script for .htpasswd | .htgroups ###############

class Htgroup {
    
    private $file = '';
    
    public function __construct($file) {
        if (file_exists($file)) {
            $this -> file = $file;
        } else {
            return false;
        }
    }
    
    private function write($groups = array()) {
        $str = '';
        foreach ($groups as $group => $users) {
            $users_str = '';
            foreach ($users as $user) {
                if (!empty($users_str)) {
                    $users_str .= ' ';
                }
                $users_str .= $user;
            }
            $str .= "$group: $users_str\n";
        }
        file_put_contents($this -> file, $str);
    }
    
    private function read() {
        $groups = array();
        $groups_str = file($this -> file, FILE_IGNORE_NEW_LINES);
        foreach ($groups_str as $group_str) {
            if (!empty($group_str)) {
                $group_str_array = explode(': ', $group_str);
                if (count($group_str_array) == 2) {
                    $users_array = explode(' ', $group_str_array[1]);
                    $groups[$group_str_array[0]] = $users_array;
                }
            }
        }
        return $groups;
    }
    
    public function addUserToGroup($username = '', $group = '') {
        if (!empty($username) && !empty($group)) {
            $all = $this -> read();
            if (isset($all[$group])) {
                if (!in_array($username, $all[$group])) {
                    $all[$group][] = $username;
                }
            } else {
                $all[$group][] = $username;
            }
            $this -> write($all);
        } else {
            return false;
        }
    }
    
    public function deleteUserFromGroup($username = '', $group = '') {
        $all = $this -> read();
        if (array_key_exists($group, $all)) {
            $user_index = array_search($username, $all[$group]);
            if ($user_index !== false) {
                unset($all[$group][$user_index]);
                if (count($all[$group]) == 0) {
                    unset($all[$group]);
                }
                $this -> write($all);
            }
        } else {
            return false;
        }
    }

}  
?>