<?php
class UserShell extends AppShell {
    var $uses = array('User');
    var $tasks = array('Userdetail');
    public function main() {
        $users = $this->User->find("all");
        foreach($users as $user){
            echo $user['User']['name']."\n";
        }
        $this->Userdetail->execute();
    }
}
