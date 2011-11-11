<?php
// Load EAV Database Connection
$read = Mage::getSingleton('core/resource')->getConnection('core_read');

// start the install
$installer 	= $this;
$installer->startSetup();

// insert template
$installer->run("
INSERT INTO {$this->getTable('core_email_template')} (`template_code`, `template_text`, `template_type`, `template_subject`, `template_sender_name`, `template_sender_email`, `added_at`, `modified_at`) VALUES
('Share Wishlist extend', '<body style=\"background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;\"><div style=\"background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;\">
<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" height=\"100%\" width=\"100%\">
    <tr>
        <td align=\"center\" valign=\"top\" style=\"padding:20px 0 20px 0\">
            <!-- [ header starts here] -->
            <table bgcolor=\"FFFFFF\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" width=\"650\" style=\"border:1px solid #E0E0E0;\">
                <tr>
                    <td valign=\"top\">
                        <a href=\"{{store url=\"\"}}\" style=\"color:#1E7EC8;\"><img src=\"{{skin url=\"images/logo_email.gif\" _area=\'frontend\'}}\" alt=\"{{var store.getFrontendName()}}\" border=\"0\"/></a>
                    </td>
                </tr>
                <!-- [ middle starts here] -->
                <tr>
                    <td valign=\"top\">
                        <p style=\"font-size:12px; line-height:16px; margin:0 0 16px 0;\">Hallo,<br/>das ist mein Wunschzettel!</p>
                        <p style=\"font-size:12px; line-height:16px; margin:0 0 16px 0;\">{{var message}}</p>
                        {{var items}}
                        <br/>
                         <strong><a href=\"{{var viewOnSiteLink}}\" style=\"color:#1E7EC8;\">Alle Artikel im Shop ansehen!</a></strong></p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor=\"#EAEAEA\" align=\"center\" style=\"background:#EAEAEA; text-align:center;\"><center><p style=\"font-size:12px; margin:0;\">Danke, <strong>{{htmlescape var=\$customer.name}}</p></center></td>
                </td>
            </table>
        </td>
    </tr>
</table>
</div>
</body>', 2, 'Schauen Sie sich {{var customer.name}}\'s Wunschzettel an', NULL, NULL, NOW(), NOW());");
$installer->endSetup();
?>
