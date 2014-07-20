<?php

/**
 * PBO API V2 SDK
 *
 * Version: 1.1.0
 */
 
class API_V2
{
	protected $_api_url = '';
	protected $_api_token = '';
	
	protected $machine_cache = array();
	
	public function __construct()
	{
	}
	
	public function make($token, $url)
	{
		$client = new API_V2();
		
		$client->_set_token($token);
		$client->_set_url($url);
		
		return $client;
	}
	
	private function _set_token($token)
	{
		$this->_api_token = $token;
	}

	private function _set_url($url)
	{
		$this->_api_url = $url;
	}

	public function get_machine_by_name($name)
	{
		$machine = null;
		
		if (array_key_exists($name, $this->machine_cache) && is_object($this->machine_cache[$name]))
		{
			return $this->machine_cache[$name];
		}
		
		/**
		 * EARLY RETURN
		 *
		 * Rather than making a bunch of nested if/else the previous statment issues an
		 * early return. While some find this to be more difficult to follow, I feel
		 * it keeps the code cleaner and easier to read overall and is worth the risk.
		 */
		
		$result = $this->send_request('get', 'machines', array('name' => $name));

		if (isset($result) && is_object($result))
		{
			$machines = $result->data;
			
			if (is_array($machines) && count($machines))
			{
				if (is_object($machines[0]))
				{
					$machine = $machines[0];
					$this->machine_cache['name'] = $machine;
				}
			}
		}
		
		return $machine;
	}
	
	public function get_meta($resource, $key)
	{
		$value = null;
		
		if (isset($resource) && isset($key) && is_object($resource) && isset($resource->metas) && is_array($resource->metas))
		{
			foreach ($resource->metas as $meta)
			{
				if ($meta->key == $key)
				{
					$value = $meta->value;
				}
			}
		}
		
		return $value;
	}
	
	public function get_meta_group($resource, $group_name)
	{
		$group = array();
		
		if (isset($resource) && isset($group_name) && is_object($resource) && isset($resource->metas) && is_array($resource->metas))
		{
			foreach ($resource->metas as $meta)
			{
				if (stripos($meta->key, $group_name . '.') === 0)
				{
					$group[str_ireplace($group_name . '.', '', $meta->key)] = $meta->value;
				}
			}
		}

		return $group;		
	}
	
	public function set_meta($resource, $key, $value)
	{
		if (!isset($resource->metas) || (isset($resource->meta) && !is_array($resource->metas)))
		{
			$resource->metas = array();
		}
		
		$meta = new stdClass();
		$meta->key = $key;
		$meta->value = $value;
		
		$exists = false;
		
		foreach ($resource->metas as &$r_meta)
		{
			if ($r_meta->key == $meta->key)
			{
				$exists = true;
				$r_meta = $meta;
			}
		}
		
		if (!$exists)
		{
			$resource->metas[] = $meta;
		}
	}

	public function get_machine_by($params)
	{
		return $this->_get_resource_by('machines', $params);
	}
		
	public function get_session_by($params)
	{
		return $this->_get_resource_by('sessions', $params);
	}

	public function get_thumbnail_by($params)
	{
		return $this->_get_resource_by('thumbnails', $params);
	}

	public function get_thumbnails_by($params)
	{
		return $this->_get_resources_by('thumbnails', $params);
	}

	public function get_photo_by($params)
	{
		return $this->_get_resource_by('photos', $params);
	}
	
	public function get_photos_by($params)
	{
		return $this->_get_resources_by('photos', $params);
	}
	
	private function _get_resource_by($requested_resource, $params)
	{
		$resource = null;
		
		$result = $this->send_request('get', $requested_resource, $params);
		
		if (isset($result) && is_object($result))
		{
			$resources = $result->data;
			
			if (is_array($resources) && count($resources))
			{
				if (is_object($resources[0]))
				{
					$resource = $resources[0];
				}
			}
		}
		
		return $resource;		
	}
	
	
	private function _get_resources_by($requested_resource, $params)
	{
		$resources = null;
		
		$result = $this->send_request('get', $requested_resource, $params);

		if (isset($result) && is_object($result) && isset($result->data) && is_array($result->data))
		{
			$resources = $result->data;
		}
		
		return $resources;		
	}	
	
	public function get_photo_by_session_uuid_and_sequence($session_uuid, $sequence)
	{
		$photo = null;
		
		$result = $this->send_request('get', 'photos', array('session_uuid' => $session_uuid));
		
		if (isset($result) && is_object($result))
		{
			$photos = $result->data;
			
			if (is_array($photos) && count($photos))
			{
				for ($i = 0; $i < count($photos); $i++)
				{
					if ($photos[$i]->sequence == $sequence)
					{
						$photo = $photos[$i];
					}
				}
			}
		}
		
		return $photo;
	}	
	
	
	public function get_user_by_session_uuid($session_uuid)
	{
		$user = null;
		
		$result = $this->send_request('get', 'users', array('session_uuid' => $session_uuid));
		
		if (isset($result) && is_object($result))
		{
			$users = $result->data;
			
			if (is_array($users) && count($users))
			{
				if (is_object($users[0]))
				{
					$user = $users[0];
				}
			}
		}
		
		return $user;
	}	

	public function get_user_by_email($email)
	{
		$user = null;
		
		$result = $this->send_request('get', 'users', array('email' => $email));
		
		if (isset($result) && is_object($result))
		{
			$users = $result->data;
			
			if (is_array($users) && count($users))
			{
				if (is_object($users[0]))
				{
					$user = $users[0];
				}
			}
		}
		
		return $user;
	}

		

	public function get_user_by_mobile($mobile)
	{
		$user = null;
		
		$result = $this->send_request('get', 'users', array('mobile' => $mobile));
		
		if (isset($result) && is_object($result))
		{
			$users = $result->data;
			
			if (is_array($users) && count($users))
			{
				if (is_object($users[0]))
				{
					$user = $users[0];
				}
			}
		}
		
		return $user;
	}
	
	public function merge_users($user1, $user2)
	{
		if (is_object($user1) && is_object($user2) && isset($user1->uuid) && isset($user2->uuid))
		{
			$this->send_request('put', 'users/merge', array($user1, $user2));
		}
	}
		
	public function machine_insert($machine)
	{		
		$this->send_request('post', 'machines', $machine);
	}

	public function machine_update($machine)
	{
		$this->send_request('put', 'machines', $machine);
	}
	

	public function machine_delete($uuid)
	{
		$this->send_request('delete', 'machines', array('uuid' => $uuid));
	}
	
	public function session_insert($session)
	{
		$this->send_request('post', 'sessions', $session);
	}

	public function session_update($session)
	{
		$this->send_request('put', 'sessions', $session);
	}

	public function notification_insert($notification)
	{
		$this->send_request('post', 'notifications', $notification);
	}

	public function notification_update($notification)
	{
		$this->send_request('put', 'notifications', $notification);
	}

	public function photo_insert($photo)
	{
		$this->send_request('post', 'photos', $photo);
	}

	public function photo_update($photo)
	{
		$this->send_request('put', 'photos', $photo);
	}


	public function thumbnail_insert($thumbnail)
	{
		$resource = null;
		
		$response = $this->send_request('post', 'thumbnails', $thumbnail);
		
		if (isset($response) && is_object($response) && isset($response->data) && is_array($response->data) && count($response->data))
		{
			$data = $response->data[0];
			
			if (isset($data->resource) && is_object($data->resource) && isset($data->success) && $data->success == true)
			{
				$resource = $data->resource;
			}
		}
		
		return $resource;
	}

	public function thumbnail_update($thumbnail)
	{
		$this->send_request('put', 'thumbnails', $thumbnail);
	}
	
	
	public function user_insert($user)
	{
		$this->send_request('post', 'users', $user);
	}

	public function user_update($user)
	{
		$this->send_request('put', 'users', $user);
	}

	
	public function send_request($type='GET', $resource='', $payload=array())
	{
		$response = null;
		
		$url = $this->_api_url . $resource . '?token=' . $this->_api_token . '&';
		
		$ch = curl_init($url);
		

		switch (strtolower($type))
		{
			case 'get':
				$data_string = http_build_query($payload);
				
				$ch = curl_init($url . $data_string);
				break;
				
			case 'delete':
			case 'put':
			case 'post':
				$data_string = json_encode($payload);
				
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Content-Type: application/json',
						'Content-Length: ' . strlen($data_string),
					)
				);                                                                                                                   
				break;
		}
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		/**
		 * Send the request
		 *
		 * We do not care what the result is or if an error occurs.
		 * this is a one time attempt.
		 */
		@$result = curl_exec($ch);
		curl_close($ch);

		
		if (isset($result) && strlen($result))
		{
			@$response = json_decode($result);
		}
		
		
		return $response;
	}
	
	public function configValue($key)
	{
		$config = new ConfigService();
		
		return $config->get($key);
	}
	
}

