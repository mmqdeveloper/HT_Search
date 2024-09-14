<?php

/*Add red="nofolow" to social links*/
if(!class_exists('avia_social_media_icons'))
{
	class avia_social_media_icons
	{
		var $args;
		var $post_data;
		var $icons = array();
		var $html  = "";
		var $counter = 1;

		/*
		 * constructor
		 * initialize the variables necessary for all social media links
		 */

		function __construct($args = array(), $post_data = array())
		{
			$default_arguments = array('outside'=>'ul', 'inside'=>'li', 'class' => 'social_bookmarks', 'append' => '');
			$this->args = array_merge($default_arguments, $args);

			$this->post_data = $post_data;

			$this->icons = apply_filters( 'avia_filter_social_icons', avia_get_option('social_icons') );
		}

		function __destruct()
		{
			unset( $this->args );
			unset( $this->post_data );
			unset( $this->icons );
		}
		/**
		 * Returns the array of social icons defined in theme options (or filtered on creating class)
		 *
		 * @since 4.8.3
		 * @return array
		 */
		function get_icons()
		{
			return $this->icons;
		}

		/**
		 * Returns the social profile info from theme options settings
		 *
		 * @since 4.8.3
		 * @param string $key
		 * @return array|false
		 */
		function get_icon( $key )
		{
			foreach( $this->icons as $icon )
			{
				if( isset( $icon['social_icon'] ) && $key == $icon['social_icon'] )
				{
					return $icon;
				}
			}

			return false;
		}

		/**
		 * Handle special URL cases
		 *
		 * @since 4.8.3
		 */
		function validate_urls()
		{
			foreach ( $this->icons as &$icon )
			{
				switch( $icon['social_icon'] )
				{
					case 'rss':
						if( empty( $icon['social_icon_link'] ) )
						{
							$icon['social_icon_link'] = get_bloginfo( 'rss2_url' );
						}
						break;
					case 'twitter':
					case 'dribbble':
					case 'vimeo':
					case 'behance':
						if( strpos( $icon['social_icon_link'], 'http' ) === false && ! empty( $icon['social_icon_link'] ) )
						{
							/**
							 * Protocoll changed with 4.5.6 to https. Allow to filter in case http is needed
							 *
							 * @since 4.5.6
							 * @return string
							 */
							$protocol = apply_filters( 'avf_social_media_icon_protocol', 'https', $icon );
							$icon['social_icon_link'] = "{$protocol}://{$icon['social_icon']}.com/{$icon['social_icon_link']}/";
						}
						break;
				}
			}

			unset( $icon );
		}
		/*
		 * function build_icon
		 * builds the html string for a single item, with a few options for special items like rss feeds
		 */

		function build_icon($icon)
		{
			global $avia_config;

			//special cases
			switch($icon['social_icon'])
			{
				case 'rss':  if(empty($icon['social_icon_link'])) $icon['social_icon_link'] = get_bloginfo('rss2_url'); break;
				case 'twitter':
				case 'dribbble':
				case 'vimeo':
				case 'behance':

				if(strpos($icon['social_icon_link'], 'http') === false && !empty($icon['social_icon_link']))
				{
					$icon['social_icon_link'] = "http://".$icon['social_icon'].".com/".$icon['social_icon_link']."/";
				}
				break;
			}

			if(empty($icon['social_icon_link'])) $icon['social_icon_link'] = "#";
			$blank = "target='_blank'";
			
			//dont add target blank to relative urls or urls to the same dmoain
			if(strpos($icon['social_icon_link'], 'http') === false || strpos($icon['social_icon_link'], home_url()) === 0) $blank = "";
			
			$html  = "";
			$html .= "<".$this->args['inside']." class='".$this->args['class']."_".$icon['social_icon']." av-social-link-".$icon['social_icon']." social_icon_".$this->counter."'>";
			$html .= "<a rel='nofollow' {$blank} href='".$icon['social_icon_link']."' ".av_icon_string($icon['social_icon'])." title='".ucfirst($icon['social_icon'])."'><span class='avia_hidden_link_text'>".ucfirst($icon['social_icon'])."</span></a>";
			$html .= "</".$this->args['inside'].">";

			return $html;
		}

		/*
		 * function html
		 * builds the html, based on the available icons
		 */

		function html()
		{
			if(!empty($this->icons))
			{
				$this->html = "<".$this->args['outside']." class='noLightbox ".$this->args['class']." icon_count_".count($this->icons)."'>";

				foreach ($this->icons as $icon)
				{
					if(!empty($icon['social_icon']))
					{
						$this->html .= $this->build_icon($icon);
						$this->counter ++;
					}
				}

				$this->html .= $this->args['append'];
				$this->html .= "</".$this->args['outside'].">";
			}


			return $this->html;
		}
	}
}
/*End */