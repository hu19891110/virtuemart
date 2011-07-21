<?php
/**
 * Administrator menu helper class
 *
 * This class was derived from the show_image_in_imgtag.php and imageTools.class.php files in VM.  It provides some
 * image functions that are used throughout the VirtueMart shop.
 *
 * @package	VirtueMart
 * @subpackage Helpers
 * @author Eugen Stranz
 * @copyright Copyright (c) 2004-2008 Soeren Eberhardt-Biermann, 2009 VirtueMart Team. All rights reserved.
 */

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ();

class AdminUIHelper {

   /**
     * Start the administrator area table
     *
     * The entire administrator area with contained in a table which include the admin ribbon menu
     * in the left column and the content in the right column.  This function sets up the table and
     * displayes the admin menu in the left column.
     */
    function startAdminArea() {
	$document = JFactory::getDocument();
//	$mainframe = JFactory::getApplication();
	//loading defaut admin CSS
	$document->addStyleSheet(JURI::base().'components/com_virtuemart/assets/css/admin_ui.css');
	$document->addStyleSheet(JURI::base().'components/com_virtuemart/assets/css/admin_menu.css');
	$document->addStyleSheet(JURI::base().'components/com_virtuemart/assets/css/admin.styles.css');
	$document->addStyleSheet(JURI::base().'components/com_virtuemart/assets/css/toolbar_images.css');
	$document->addStyleSheet(JURI::base().'components/com_virtuemart/assets/css/menu_images.css');
	$document->addStyleSheet(JURI::root(true).'/components/com_virtuemart/assets/css/tipTip.css');
	//$document->addStyleSheet(JURI::base().'components/com_virtuemart/assets/css/jqtransform.css');

	//loading defaut admin script
	$document->addScript(JURI::base().'components/com_virtuemart/assets/js/vm2admin.js');
	$document->addScript(JURI::base().'components/com_virtuemart/assets/js/jquery.cookie.js');
	$document->addScript(JURI::root(true).'/components/com_virtuemart/assets/js/jquery.tipTip.js');
	//$document->addScript(JURI::base().'components/com_virtuemart/assets/js/jquery.jqtransform.js');

	?>

        <div class="virtuemart-admin-area">
        <?php 
        // Include ALU System
require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'liveupdate'.DS.'liveupdate.php';
echo LiveUpdate::getIcon(array(),'notice');
?>
         	<div class="menu-wrapper">
		<?php AdminUIHelper::showAdminMenu(); ?>
        	</div>


        	<div id="admin-content-wrapper">
        		<div id="admin-content" class="admin-content">
		<?php
	    }


	    /**
	     * Close out the adminstrator area table.
	     * @author RickG, Max Milbers
	     */
	    function endAdminArea() {
			if (VmConfig::get('debug') == '1') {
			//TODO maybe add debuggin again here
//		    include(JPATH_VM_ADMINISTRATOR.'debug.php');
			}
		?>
				<div class="clear"></div>
    			</div>
    		</div>

    	<div class="clear"></div>
		</div>
	<?php 
	    }

	/**
	 * Admin UI Tabs
	 * Gives A Tab Based Navigation Back And Loads The Templates With A Nice Design
	 * @param $load_template = a key => value array. key = template name, value = Language File contraction
	 * @params $cookieName = choose a cookiename or leave empty if you dont want cookie tabs in this place
	 * @example 'shop' => 'COM_VIRTUEMART_ADMIN_CFG_SHOPTAB'
	 */
	function buildTabs($load_template = array(),$cookieName='') {
		$cookieName = JRequest::getVar('view','').$cookieName;
		$document = JFactory::getDocument ();
		//$document->addScript ( JURI::base () . 'components/com_virtuemart/assets/js/tabs.js' );
		$document->addScriptDeclaration ( '
			jQuery(document).ready(function() {
				jQuery("#admin-ui-tabs").vm2admin("tabs","'.$cookieName.'");
			});');

		$html = '<div id="admin-ui-tabs">';

		foreach ( $load_template as $tab_content => $tab_title ) {
			$html .= '<div class="tabs" title="' . JText::_ ( $tab_title ) . '">';
			$html .= $this->loadTemplate ( $tab_content );
			$html .= '<div class="clear"></div></div>';
		}
		$html .= '</div>';
		echo $html;
	}
	
	/**
	 * Admin UI Tabs Imtation
	 * Gives A Tab Based Navigation Back And Loads The Templates With A Nice Design
	 * @param $return = return the start tag or the closing tag - choose 'start' or 'end'
	 * @params $language = pass the language string
	 */
	function imitateTabs($return,$language = '') {
		if ($return == 'start') {
			$html = 	'<div id="admin-ui-tabs">
							<ul id="tabs">
								<li class="current">'.JText::_($language).'</li>
							</ul>
							<div class="tabs">';
			echo $html;
		}
		if ($return == 'end') {
			$html = '		</div>
						</div>';
			echo $html;
		}
	}

	/**
	 * Build an array containing all the menu items.
	 *
	 * @param int $moduleId Id of the module to filter on
	 */
	function _getAdminMenu($moduleId = 0) {
		$db = JFactory::getDBO ();
		$menuArr = array ();

		$filter [] = "jmmod.published='1'";
		$filter [] = "item.published='1'";
		$filter [] = "jmmod.is_admin='1'";
		if (! empty ( $moduleId )) {
			$filter [] = 'vmmod.module_id=' . ( int ) $moduleId;
		}

		$query = 'SELECT `jmmod`.`module_id`, `module_name`, `module_perms`, `id`, `name`, `link`, `depends`, `icon_class`, `view`, `task`';
		$query .= 'FROM `#__virtuemart_modules` AS jmmod ';
		$query .= 'LEFT JOIN `#__virtuemart_adminmenuentries` AS item ON `jmmod`.`module_id`=`item`.`module_id` ';
		$query .= 'WHERE  ' . implode ( ' AND ', $filter ) . ' ';
		$query .= 'ORDER BY `jmmod`.`ordering`, `item`.`ordering`';
		$db->setQuery ( $query );
		$result = $db->loadObjectList ();
		//		echo '<pre>'.print_r($query,1).'</pre>';
		for($i = 0, $n = count ( $result ); $i < $n; $i ++) {
			$row = $result [$i];
			$menuArr [$row->module_name] ['title'] = 'COM_VIRTUEMART_' . strtoupper ( $row->module_name ) . '_MOD';
			$menuArr [$row->module_name] ['items'] [] = array ('name' => $row->name, 'link' => $row->link, 'depends' => $row->depends, 'icon_class' => $row->icon_class, 'view' => $row->view, 'task' => $row->task );
		}
		return $menuArr;
	}

	/**
	 * Display the administrative ribbon menu.
	 * @todo The link should be done better
	 */
	function showAdminMenu() {
		$document = JFactory::getDocument ();
		$moduleId = JRequest::getInt ( 'module_id', 0 );

		$menuItems = AdminUIHelper::_getAdminMenu ( $moduleId );
		?>

		<div id="admin-ui-menu" class="admin-ui-menu">

		<?php
		$modCount = 1;
		foreach ( $menuItems as $item ) { ?>

			<h3 class="menu-title">
				<?php echo JText::_ ( $item ['title'] )?>
			</h3>

			<div class="menu-list">
				<ul>
				<?php
				foreach ( $item ['items'] as $link ) {
					if ($link ['name'] == '-') {
						// it was emtpy before
					} else {
						if (strncmp ( $link ['link'], 'http', 4 ) === 0) {
							$url = $link ['link'];
						} else {
							if ($link ['view']) {
								$url = 'index.php?option=com_virtuemart&view=' . $link ['view'];
								$url .= $link ['task'] ? "&task=" . $link ['task'] : '';
								// $url .= $link['extra'] ? $link['extra'] : '';
								$url = strncmp ( $link ['view'], 'http', 4 ) === 0 ? $link ['view'] : $url;
							} else {
								//							    $url = 'index2.php?option=com_virtuemart&'.$link['link'];
							}
						}
						?>
					<li>
						<a class="<?php echo $link ['icon_class'] ?>" href="<?php echo $url; ?>"><?php echo JText::_ ( $link ['name'] )?></a>
					</li>
					<?php
					}
				}
				?>
			    </ul>
			</div>

			<?php
			$modCount ++;
		}
		?>
		</div>
	<?php
	}

}

?>