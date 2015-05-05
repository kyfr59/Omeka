<?php
    if ($_SERVER['HTTP_HOST'] == 'localhost')
        define('OMEKA_ROOT', 'http://localhost');
    else if($_SERVER['HTTP_HOST'] == '192.168.0.18')
        define('OMEKA_ROOT', 'http://192.168.0.18');
    else
        define('OMEKA_ROOT', 'http://documents.studens.info');
?>
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
            <h3>Studens</h3>
            Studens est le portail des archives et ressources documentaires sur les engagements étudiants. Il est porté par la Cité des mémoires étudiantes.<br />
            <a target="_blank" href="http://www.citedesmemoiresetudiantes.org" class="site">Visitez citedesmemoiresetudiantes.org</a>
        </div>
        <div class="contact">
            <h3>Studens</h3>
            <span>Standard de 9h à 18h</span>
            <span>Tél: +33 (0)1 43 52 88 04</span>
            <a href="mailto:studens@citedesmemoiresetudiantes.org">studens@citedesmemoiresetudiantes.org</a>
        </div>
        <div class="contact">
            <h3>Dernières notices</h3>
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
            <a href="https://twitter.com/port_studens" class="fa fa-twitter"><i>Twitter</i></a>
            <a href="https://www.facebook.com/cite.etudiantes?fref=ts" class="fa fa-google"><i>Google +</i></a>
            <a href="#" class="fa fa-vimeo-square"><i>Vimeo</i></a>
            <a href="#" class="fa fa-flickr"><i>Flickr</i></a>
            <a href="#" class="fa fa-rss"><i>Rss</i></a>

        </div>
        <div class="mentions">
            <a href="http://www.studens.info/mentions-legales/">Mentions légales</a>&nbsp;&nbsp;-&nbsp;
            <a href="http://www.studens.info/?p=104/">CGU</a>&nbsp;&nbsp;-&nbsp;
            <a href="http://www.studens.info/contact/">Contact</a><br />
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





