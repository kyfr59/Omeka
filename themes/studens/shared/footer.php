<?php
    if ($_SERVER['HTTP_HOST'] == 'localhost')
        define('OMEKA_ROOT', 'http://localhost');
    else if($_SERVER['HTTP_HOST'] == '192.168.0.18')
        define('OMEKA_ROOT', 'http://192.168.0.18');
    else
        define('OMEKA_ROOT', 'http://documents.studens.info');
?>
<link href="<?php echo OMEKA_ROOT ?>/themes/studens/shared/shared.css" media="screen" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

<?php
$months[01] = 'Janvier';
$months[02] = 'Février';
$months[03] = 'Mars';
$months[04] = 'Avril';
$months[05] = 'Mai';
$months[06] = 'Juin';
$months[07] = 'Juillet';
$months[08] = 'Août';
$months[09] = 'Septembre';
$months[10] = 'Octobre';
$months[11] = 'Novembre';
$months[12] = 'Décembre';
$recent = get_recent_items(3); 
?>

<div id="footer-studens">
    <div id="footer-content">
        <div class="contact left">
            <h3>cité des mémoires étudiantes</h3>
            Altera sententia est, quae definit amicitiam paribus officiis ac voluntatibus. Hoc quidem est nimis exigue et exiliter ad calculos vocare amicitiam, definit amicitiam paribus officiis ac ut par sit.<br />
            <a href="#" class="site">Visitez citedesmemoiresetudiantes.org</a>
        </div>
        <div class="contact">
            <h3>studens</h3>
            <span>Standard de 9h cà 18h</span>
            <span>Tél: +33 (0)1 44 55 66 77 88</span>
            <a href="">contact@citedesmemoiresetudiantes.org</a>
        </div>
        <div class="contact">
            <h3>derniers inventaires</h3>
            <?php 
            foreach($recent as $item) {
                $title = metadata($item, array('Dublin Core', 'Title'));
                $url = record_url($item);
                $date = $item->added;
                $dateFrench = ltrim(date("d ", strtotime($date)), '0'). strtolower($months[(int)date("m ", strtotime($date))]). date(" Y ", strtotime($date));
                echo "<a href='".$url."'>".$title."</a>";
                echo "<strong>".$dateFrench."</strong>";
                echo "<hr />";
            }
            ?>        
        </div>
        <br style="clear:both" />
        
    </div>
    <div class="bottom">
        <div id="bg"></div>
        <div class="social">
            <a href="#" class="fa fa-facebook"><i>Facebook</i></a>
            <a href="#" class="fa fa-twitter"><i>Twitter</i></a>
            <a href="#" class="fa fa-google"><i>Google +</i></a>
            <a href="#" class="fa fa-vimeo-square"><i>Vimeo</i></a>
            <a href="#" class="fa fa-flickr"><i>Flickr</i></a>
            <a href="#" class="fa fa-rss"><i>Rss</i></a>

        </div>
        <div class="mentions">
            <a href="#">Mentions légales</a>
            <a href="#">Contact</a><br />
            Copyright &copy; citememoiresetudiantes.org<br />
            Tous droits réservés
        </div>
        <div class="logos">
            <a target="_new" href="http://www.archivesdefrance.culture.gouv.fr"><img src="<?php echo OMEKA_ROOT ?>/themes/studens/images/footer-bottom-adf.png" /></a>
            <a target="_new" href="http://www.iledefrance.fr"><img src="<?php echo OMEKA_ROOT ?>/themes/studens/images/footer-bottom-idf.png" /></a>
            <a target="_new" href="http://www.citedesmemoiresetudiantes.org"><img src="<?php echo OMEKA_ROOT ?>/themes/studens/images/footer-bottom-cme.png" /></a>
            <a target="_new" href="http://www.huma-num.fr"><img class="hn" src="<?php echo OMEKA_ROOT ?>/themes/studens/images/footer-bottom-hn.png" /></a>
        </div>
        <p>Avec le soutien financier de la région Ile-de-France et du Ministère de la Culture et de la Communication (Service interministériel des archives de France)</p>
        

    </div>
</div>





