<?php
namespace Libs;

use \Phalcon\Di\Injectable as Injector;


class Auth extends Injector
{   
	/*
	* @mixed $_user
	*/
	protected $_user;
	
	/*
	* @boolean $_loggedOut;
	*/
	protected $_loggedOut = false;
    
    

   /*
    * @return user if exists
    */   
	public function user()
	{
		if($this->_loggedOut)
		{
            return null;
		}

		if(!is_null($this->_user))
		{
           return $this->_user;
		} 


		if($this->session->has($this->sessionKey()))
		{
            $id = $this->session->get($this->sessionKey());
		}
		else
		{
            $id = null; 
		}

		if(!is_null($id))
		{
           $this->_user = $this->retreiveById($id);
		}

		return $this->_user;
	}

  
	public function guest()
	{
	   return $this->check();
	}
    


	public function attempt(array $creditentials = array())
	{
		    $condintion = $this->toWhereCondintion($creditentials);

		    $user = \Users::findfirst([
	             "({$condintion})",
	             "bind"       => $creditentials
            ]);



		   if($user != false)
		   {
              $this->loginUsingId($user->id);
                		     
              return true;
		   }
		   else
		   {
              return false;
		   }



	}

	/*
	 * Create Where Condition
	 * @param array $creditentials
	 * @return string $cond
	 */

	public function toWhereCondintion($creditentials)
	{

		$cond = '';
		$i    = 1;
        
        foreach($creditentials as $key => $value)
        {
            $cond .= $key." = :".$key.":";
            
            if($i < count($creditentials)) 
            {
               $cond .= " AND "; 
            }

            $i++;

        }
       
       return $cond;

	}

    /*
     * Check if user is set
     * @return boolean 
     */
	public function check()
	{ 
		return is_null($this->session->get($this->sessionKey()));
    }
     
     /*
      * Log user out
      */
	public function logout()
	{
        $this->_user      = null;
        $this->_loggedOut = true;

        $this->session->destroy(); 

	}
     
     /*
      * 
      */
	public function id()
	{
		if($this->session->has($this->sessionKey()))
        {
           return $this->session->get($this->sessionKey());
        }

        return null;
	}

    /*
     * Log User in
     * @return void
     */
	public function login($user)
	{

		if($user === false)
		{
           return false;
		}
    
		$this->regenerateSessionId();
		$this->session->set($this->sessionKey(),$user->id);
    
	}

    /*
    * @return userid
    */
	public function sessionKey()
	{
		return $this->config->session->id;
	}
     
     /*
      * Retreive user by id
      * @return Object user
      */
	public function retreiveById($id)
	{

       return \Users::findfirst($id);
	}

	public function loginUsingId($id)
	{

        $this->login($this->retreiveById($id));
	}

    
     /*
      * Regenerate Session ID 
      */
	public function regenerateSessionId()
	{
         session_regenerate_id(false);
	}



}

?>