<?php __($this->element('header')); ?>
<div class="header_text_bg"></div>
   <div class="header_text">
      <div class="div">
        <div class="left1">
       	  <div class="client_text">
       	    <table height="68">
              <tbody><tr>
                <td height="62" width="225"><span class="style4"> <div align="center"><i>Fast</i>. Reliable.</div>
                <u><b><div align="center">Stress Free</div></b></u><div align="center">Service.</div></span><span class="style4"></span></td>
                <td width="238" align="left"><div align="left"> <div class="notary_text style4">
                  <div align="center">Build &amp; Better </div>
                  <div align="center"><strong>Your </strong></div>
            <div align="center">Business.<br>
            </div>
                </div></div></td>
              </tr>
            </tbody></table>
       	    <div align="left">
              <table align="left">
        <tbody><tr>
        <td width="221"><center><?php __($html->image('simple_view.png', array('alt'=>'Clients', 'title'=>'Clients','url'=> 'http://www.1hoursignings.com/clients'))); ?>
        </center></td>
        <td width="10" align="left">
        </td><td width="220"><div align="center"><?php __($html->image('simple_port.png', array('alt'=>'Notaries', 'title'=>'Notaries', 'url'=> 'http://www.1hoursignings.com/notaries'))); ?>
        </div>
              </td></tr>
        </tbody></table>
       	  </div>
        </div>
      </div>
      <div class="gallery">
        <div style="width: 386px; height: 226px; overflow: hidden;" id="slider">
          <ul style="width: 1158px; margin-left: -771.619px;">
            <li style="float: left;"><?php __($html->image('simple_img_1.jpg', array('alt'=>'logo', 'title'=>'logo', 'height'=>'226', 'width'=>'386'))); ?></li>
            <li style="float: left;"><?php __($html->image('simple_img_2.jpg', array('alt'=>'logo', 'title'=>'logo', 'height'=>'226', 'width'=>'386'))); ?></li>
            <li style="float: left;"><?php __($html->image('simple_img_3.jpg', array('alt'=>'logo', 'title'=>'logo', 'height'=>'226', 'width'=>'386'))); ?></li>
          </ul>
        </div>
      </div>
    </div>
  </div>  
  <div class="body_resize">
    <div class="body">
    <div class="body_small">
       <?php __($this->element('newsandevents')); ?>
       <?php __($this->element('getintouch')); ?>
       <?php __($this->element('followus')); ?>
	</div>
	<div class="body_big">
      	<h3><span class="style2">Clients...</span> 
			<span class="home_head style3"><b>Discover How <?php __(Configure::read('sitename')); ?> Assigns</b>
			<center><b _moz-rs-heading="">A Notary <i><spanner>Within 1 Hour</spanner></i>!</b></center></span></h3>
			<div class="bg"></div>
			<div style="width: 200px;" class="fleft"><?php __($html->image('check_signing.png', array('alt'=>'', 'title'=>''))); ?><?php __($html->image('become_client.png', array('alt'=>'Become a Client', 'title'=>'Become a Client','url'=>array('controller'=>'users','action'=>'signup','type'=>Inflector::slug('become a client'),'who'=>'client')))); ?><?php __($html->image('signing_agent.png', array('alt'=>'', 'title'=>''))); ?><p align="center"></p></div><div style="width: 335px; padding-left: 200px;"><p><b><?php __(Configure::read('sitename')); ?> is a nationwide signing service dedicated to providing fast, reliable solutions. <br>We guarantee assignment of a notary anytime, anywhere nationwide within 1 hour with the <?php __(Configure::read('sitename')); ?> Service Level Agreement.</b></p><p><b>With our expertise and innovative strategies, you have peace of mind knowing we will get the signing done. We help you best service your clients, now! </b></p><p align="center"><b><?php __($html->link('Click here', array('#'))); ?> to assign a notary right away.</b></p>
</div>
<hr width="100%" />
<h3><span class="style3"><b _moz-rs-heading=""><strong>Notaries... </strong></b></span><span class="style3"><span class="home_head1 style3"><b _moz-rs-heading=""><?php __(Configure::read('sitename')); ?> Reveals How You Can <br>
          </b><center><b _moz-rs-heading="">Get <i>
          <spanner>More Signings</spanner>
          </i> In Your Area!<br>
        </b></center></span></span></h3>
<hr width="100%" />
<div style="width: 200px;" class="fleft">
	<p align="center"><b>
		<?php __($html->image('notary.png', array('alt'=>'Become a 1Hr Notary', 'title'=>'Become a 1Hr Notary', 'url'=>array('controller'=>'users','action'=>'signup','type'=>Inflector::slug('become a 1hr notary'),'who'=>'beginner')))); ?>
		<?php __($html->image('join.png', array('alt'=>'Join Our Professional Network', 'title'=>'Join Our Professional Network','url'=>array('controller'=>'users','action'=>'signup','type'=>Inflector::slug('join our professional network'),'who'=>'professional')))); ?></b></p>
</div>
<div style="width: 335px; padding-left: 200px;">
<p><b>As a notary, more signings means making more money. Whether you're a new notary or a seasoned veteran, you are probably looking for ways to get more signings yet you're not sure how.</b></p>
<p align="center"><b><b><?php __($html->link('Click here', array('#'))); ?></b> to discover how only 15 minutes a day can dramatically improve your business.</b></p>
</div>
<hr width="100%" />
</div>
<div class="clr"></div>
</div>
</div>
<?php __($this->element('footer')); ?>