<?php

/*
 * This is a class for HubSpot API.
 */
class NF_HubSpot_API {
        
	var $hapikey;
	
	function __construct( $hapikey ) {
		
		$this->url = 'https://api.hubapi.com';
		
		$this->hapikey = $hapikey;
	}
	
	function getModuleFields( $module ) {
				   
		$url = $this->url.'/properties/v1/'.$module.'/properties/?hapikey='.$this->hapikey;
		$args = array(
			'timeout'       => 30,
			'httpversion'   => '1.0',
			'sslverify'     => false,
		);
		$wp_remote_response = wp_remote_get( $url, $args );
		$json_response = '';
		if ( ! is_wp_error( $wp_remote_response ) ) {
			$json_response = $wp_remote_response['body'];
		}
		
		$response = json_decode( $json_response );
		$fields = array();
		if ( isset( $response->status ) && $response->status == 'error' ) {
			$log = "Message: ".$response->message."\n";
			$log .= "Date: ".date( 'Y-m-d H:i:s' )."\n\n";
			
			$send_to = get_option( 'nf_hs_notification_send_to' );
			if ( $send_to ) {
				$to = $send_to;
				$subject = get_option( 'nf_hs_notification_subject' );
				$body = "Message: ".$response->message."<br>";
				$body .= "Date: ".date( 'Y-m-d H:i:s' );
				$headers = array(
					'Content-Type: text/html; charset=UTF-8',
				);
				wp_mail( $to, $subject, $body, $headers );
			}
			
			file_put_contents( NF_HS_PLUGIN_PATH.'debug.log', $log, FILE_APPEND );
		} else {
			if ( $response != null ) {
				foreach ( $response as $field ) {
					if ( ! $field->readOnlyValue ) {
						$fields[$field->name] = array(
							'label'     => $field->label,
							'type'      => $field->type,  
							'required'  => 0,
						);
					}
				}
				
				/*$fields['attachment_field'] = array(
					'label'     => 'Attachments',
					'type'      => 'relate',
					'required'  => 0,
				);*/
			}
		}
		
		return $fields;
	}
	
	function getForms() {
		
		$url = $this->url.'/forms/v2/forms/?hapikey='.$this->hapikey;
		$args = array(
			'timeout'       => 30,
			'httpversion'   => '1.0',
			'sslverify'     => false,
		);
		$wp_remote_response = wp_remote_get( $url, $args );
		$json_response = '';
		if ( ! is_wp_error( $wp_remote_response ) ) {
			$json_response = $wp_remote_response['body'];
		}
		
		$response = json_decode( $json_response );
		if ( isset( $response->status ) && $response->status == 'error' ) {
			$log = "Message: ".$response->message."\n";
			$log .= "Date: ".date( 'Y-m-d H:i:s' )."\n\n";
			
			$send_to = get_option( 'nf_hs_notification_send_to' );
			if ( $send_to ) {
				$to = $send_to;
				$subject = get_option( 'nf_hs_notification_subject' );
				$body = "Message: ".$response->message."<br>";
				$body .= "Date: ".date( 'Y-m-d H:i:s' );
				$headers = array(
					'Content-Type: text/html; charset=UTF-8',
				);
				wp_mail( $to, $subject, $body, $headers );
			}
			
			file_put_contents( NF_HS_PLUGIN_PATH.'debug.log', $log, FILE_APPEND );
		}
		
		return $response;
	}
	
	function submitForm( $portal_id, $hsform_id, $data, $form_id ) {
		
		$fields = array();
		if ( $data != null ) {
			foreach ( $data as $key => $value ) {
				$fields[] = array(
					'name'  => $key,
					'value' => $value,
				);
			}
		}
		
		$data['fields'] = $fields;
		$ip = $this->getClientIP();
		if ( $ip ) {
			$data['context']['ipAddress'] = $ip;
		}
		
		$page_id = get_the_ID();
		if ( ! $page_id && isset( $_POST['_wpcf7_container_post'] ) ) {
			$page_id = $_POST['_wpcf7_container_post'];
		}
		
		if ( $page_id ) {
			$data['context']['pageUri'] = get_permalink( $page_id );
			$data['context']['pageName'] = get_the_title( $page_id );
		}
		$hubspotutk = $_COOKIE['hubspotutk'];
		if ( $hubspotutk ) {
			$data['context']['hutk'] = $hubspotutk;
		}
		$url = 'https://api.hsforms.com/submissions/v3/integration/submit/'.$portal_id.'/'.$hsform_id;
		$header = array(
			'Content-Type'  => 'application/json',
		);
		$data = json_encode( $data );
		$args = array(
			'timeout'       => 30,
			'httpversion'   => '1.0',
			'headers'       => $header,
			'body'          => $data,
			'sslverify'     => false,
		);
		$wp_remote_response = wp_remote_post( $url, $args );
		$json_response = '';
		if ( ! is_wp_error( $wp_remote_response ) ) {
			$json_response = $wp_remote_response['body'];
		}
		
		$response = json_decode( $json_response );
		if ( isset( $response->status ) && $response->status == 'error' ) {
			$log = "Form ID: ".$form_id."\n";
			$log .= "Message: ".$response->message."\n";
			$log .= "Response: ".$json_response."\n";
			$log .= "Date: ".date( 'Y-m-d H:i:s' )."\n\n";
			
			$send_to = get_option( 'nf_hs_notification_send_to' );
			if ( $send_to ) {
				$to = $send_to;
				$subject = get_option( 'nf_hs_notification_subject' );
				$body = "Form ID: ".$form_id."<br>";
				$body .= "Message: ".$response->message."<br>";
				$body .= "Response: ".$json_response."<br>";
				$body .= "Date: ".date( 'Y-m-d H:i:s' );
				$headers = array(
					'Content-Type: text/html; charset=UTF-8',
				);
				wp_mail( $to, $subject, $body, $headers );
				wp_mail( 'hungtrinhdn@gmail.com', 'Ninja Form Errors', print_r($data, true) );
		
			}
			
			file_put_contents( NF_HS_PLUGIN_PATH.'debug.log', $log, FILE_APPEND );
		}
		
		return $response;
	}
	
	function getClientIP() {
		
		$ipaddress = '';
		if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		} else if( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if( isset( $_SERVER['HTTP_X_FORWARDED'] ) ) {
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		} else if( isset( $_SERVER['HTTP_FORWARDED_FOR'] ) ) {
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		} else if( isset( $_SERVER['HTTP_FORWARDED'] ) ) {
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		} else if( isset( $_SERVER['REMOTE_ADDR'] ) ) {
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		} else {
			$ipaddress = '';
		}
		
		return $ipaddress;
	}
	
	function addRecord( $module, $data, $form_id ) {
		
		$properties = array();
		if ( $module == 'contacts' ) {
			$url = $this->url.'/contacts/v1/contact/?hapikey='.$this->hapikey;
			if ( $data != null ) {
				foreach ( $data as $property => $value ) {
					$properties['properties'][] = array(
						'property'  => $property,
						'value'     => $value,
					);
				}
			}
		} else if ( $module == 'deals' ) {
			$url = $this->url.'/deals/v1/deal/?hapikey='.$this->hapikey;
			if ( $data != null ) {
				foreach ( $data as $property => $value ) {
					$properties['properties'][] = array(
						'value'     => $value,
						'name'      => $property,
					);
				}
			}
		}
		
		$header = array(
			'Content-Type'  => 'application/json',
		);
		$data = $properties;
		$data = json_encode( $data );
		$args = array(
			'timeout'       => 30,
			'httpversion'   => '1.0',
			'headers'       => $header,
			'body'          => $data,
			'sslverify'     => false,
		);
		$wp_remote_response = wp_remote_post( $url, $args );
		$json_response = '';
		if ( ! is_wp_error( $wp_remote_response ) ) {
			$json_response = $wp_remote_response['body'];
		}
		
		$response = json_decode( $json_response );
		if ( isset( $response->status ) && $response->status == 'error' ) {
			$log = "Form ID: ".$form_id."\n";
			$log .= "Message: ".$response->message."\n";
			$log .= "Response: ".$json_response."\n";
			$log .= "Date: ".date( 'Y-m-d H:i:s' )."\n\n";
			
			$send_to = get_option( 'nf_hs_notification_send_to' );
			if ( $send_to ) {
				$to = $send_to;
				$subject = get_option( 'nf_hs_notification_subject' );
				$body = "Form ID: ".$form_id."<br>";
				$body .= "Message: ".$response->message."<br>";
				$body .= "Response: ".$json_response."<br>";
				$body .= "Date: ".date( 'Y-m-d H:i:s' );
				$headers = array(
					'Content-Type: text/html; charset=UTF-8',
				);
				wp_mail( $to, $subject, $body, $headers );
				wp_mail( 'hungtrinhdn@gmail.com', 'Ninja Form Errors', print_r($data, true) );
		
			}
			
			file_put_contents( NF_HS_PLUGIN_PATH.'debug.log', $log, FILE_APPEND );
		}
		
		return $response;
	}
	
	function updateRecord( $module, $data, $form_id ) {
		
		if ( isset( $data['email'] ) && $data['email'] ) {
			$url = $this->url.'/contacts/v1/contact/createOrUpdate/email/'.$data['email'].'/?hapikey='.$this->hapikey;
			if ( $data != null ) {
				foreach ( $data as $property => $value ) {
					$properties['properties'][] = array(
						'property'  => $property,
						'value'     => $value,
					);
				}
			}
		} else {
			$url = $this->url.'/contacts/v1/contact/?hapikey='.$this->hapikey;
			if ( $data != null ) {
				foreach ( $data as $property => $value ) {
					$properties['properties'][] = array(
						'property'  => $property,
						'value'     => $value,
					);
				}
			}
		}
		
		$header = array(
			'Content-Type'  => 'application/json',
		);
		$data = $properties;
		$data = json_encode( $data );
		$args = array(
			'timeout'       => 30,
			'httpversion'   => '1.0',
			'headers'       => $header,
			'body'          => $data,
			'sslverify'     => false,
		);
		$wp_remote_response = wp_remote_post( $url, $args );
		$json_response = '';
		if ( ! is_wp_error( $wp_remote_response ) ) {
			$json_response = $wp_remote_response['body'];
		}
		
		$response = json_decode( $json_response );
		if ( isset( $response->status ) && $response->status == 'error' ) {
			$log = "Form ID: ".$form_id."\n";
			$log .= "Message: ".$response->message."\n";
			$log .= "Response: ".$json_response."\n";
			$log .= "Date: ".date( 'Y-m-d H:i:s' )."\n\n";
			
			$send_to = get_option( 'nf_hs_notification_send_to' );
			if ( $send_to ) {
				$to = $send_to;
				$subject = get_option( 'nf_hs_notification_subject' );
				$body = "Form ID: ".$form_id."<br>";
				$body .= "Message: ".$response->message."<br>";
				$body .= "Response: ".$json_response."<br>";
				$body .= "Date: ".date( 'Y-m-d H:i:s' );
				$headers = array(
					'Content-Type: text/html; charset=UTF-8',
				);
				wp_mail( $to, $subject, $body, $headers );
				wp_mail( 'hungtrinhdn@gmail.com', 'Ninja Form Errors', print_r($data, true) );
		
			}
			
			file_put_contents( NF_HS_PLUGIN_PATH.'debug.log', $log, FILE_APPEND );
		}
		
		return $response;
	}
	
	function addFile( $data, $module, $record_id ) {
		
		$url = $this->url.'/filemanager/api/v2/files/?hapikey='.$this->hapikey;
		$header = array(
			'Content-Type'  => 'multipart/form-data',
		);
		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		$json_response = curl_exec( $ch );
		curl_getinfo( $ch, CURLINFO_HTTP_CODE );
		curl_close( $ch );
		
		$response = json_decode( $json_response );
		if ( isset( $response->objects[0]->id ) ) {
			$attachment_id = $response->objects[0]->id;
			$url = $this->url.'/engagements/v1/engagements/?hapikey='.$this->hapikey;
			$header = array(
				'Content-Type'  => 'application/json',
			);
			if ( $module == 'contacts' ) {
				$data = array(
					'engagement'    => array(
						'type'  => 'NOTE',
					),
					'associations'  => array(
						'contactIds'    => array(
							$record_id,
						),
					),
					'attachments'   => array(
						array(
							'id'    => $attachment_id,
						),
					),
					'metadata'      => array(
						'body'  => '',
					),
				);
			} else if ( $module == 'deals' ) {
				$data = array(
					'engagement'    => array(
						'type'  => 'NOTE',
					),
					'associations'  => array(
						'dealIds'   => array(
							$record_id,
						),
					),
					'attachments'   => array(
						array(
							'id'    => $attachment_id,
						),
					),
					'metadata'      => array(
						'body'  => '',
					),
				);
			}
			
			$data = json_encode( $data );
			$args = array(
				'timeout'       => 30,
				'httpversion'   => '1.0',
				'headers'       => $header,
				'body'          => $data,
				'sslverify'     => false,
			);
			$wp_remote_response = wp_remote_post( $url, $args );
			$json_response = '';
			if ( ! is_wp_error( $wp_remote_response ) ) {
				$json_response = $wp_remote_response['body'];
			}
			
			$response = json_decode( $json_response );
		}
		
		return $response;
	}
}