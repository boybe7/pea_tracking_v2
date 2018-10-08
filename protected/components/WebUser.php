<?php
// this file must be stored in:
// protected/components/WebUser.php

class WebUser extends CWebUser {

// Store model to not repeat query.
private $_model;

// Return
// access it by Yii::app()->user->username
function getUsername(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->username;
   // return $user->title." ".$user->firstname." ".$user->lastname;
}
// access it by Yii::app()->user->title
function getTitle(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->title;
    
}
// access it by Yii::app()->user->firstname
function getFirstName(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->firstname;
    
}
// access it by Yii::app()->user->lastname
function getLastName(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->lastname;
    
}

function getUserDept(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->department_id;
    
}
// access it by Yii::app()->user->usertype
function getUsertype(){
    $user = $this->loadUser(Yii::app()->user->id);
    
    if(Yii::app()->user->id == 0)
    {  
        
        return "guest";     
    }
    else    
         return "user";
}

// This is a function that checks the field 'role'
// in the User model to be equal to 1, that means it's admin
// Yii::app()->user->isGuest
// Yii::app()->user->isAdmin()
// Yii::app()->user->isDoctor()
// Yii::app()->user->isNurse()
// Yii::app()->user->isCashier()
 function isAdmin(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->u_group == "1";
    //return UserModule::isAdmin();
  }

function isSuperUser(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->u_group == "2";
}
function isUser(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->u_group == "3";
}
function isExecutive(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->u_group == "4";
}

// Load user model.
protected function loadUser($id=null)
{
    if($this->_model===null)
    {
        if($id!==null)
            $this->_model=User::model()->findByPk($id);
        else
        {
            $this->_model = new User();
            $this->_model->username = "Guest";
            $this->_model->u_group = 0;
        }
    }
    return $this->_model;
}

}
?>
