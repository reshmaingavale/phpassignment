<?php
class UserdetailTask extends Shell {
    var $uses = array('User'); // same as controller var $uses
    function execute()
    {
        echo "Here are the details\n";
        $users=$this->User->find("all");
        foreach($users as $user){
            echo "Name:- ".$user['User']['name']."\n";
            echo "Username:- ".$user['User']['username']."\n";
        }

    }

}
