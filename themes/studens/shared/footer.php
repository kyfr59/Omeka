<?php
    if ($_SERVER['HTTP_HOST'] == 'localhost')
        define('OMEKA_ROOT', 'http://localhost');
    else if($_SERVER['HTTP_HOST'] == '192.168.0.18')
        define('OMEKA_ROOT', 'http://192.168.0.18');
    else
        define('OMEKA_ROOT', 'http://documents.studens.info');
?>
   
<link href="<?php echo OMEKA_ROOT ?>/themes/studens/shared/shared.css" media="screen" rel="stylesheet" type="text/css" >
      

<?php

// Retrieving last articles 
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


<style>
#footer-studens {
    margin:0;
    padding:0;
    background-color:#efe5ca !important;
    margin:0 auto;
    font-family: CalibriRegular, Calibri, Candara, Segoe, 'Segoe UI', Optima, Arial, sans-serif;
}

#footer-content {
    width:1130px;
    padding: 50px;
    margin:0 auto;
    background:none !important;
    border:1px solid red;
}


#footer-content div.contact {
    display:block;
    width:320px;
    margin-right:50px;
    float:left;
    font-size:16px;
}

#footer-content div.left {
    margin-left:20px;
}

#footer-content h3 {
    font-size:20px;
    font-weight:bold;
    color:#0F565A;   
    margin-bottom:10px;
}

#footer-content span {
    display:block;
}

#footer-content a,
#footer-content a:hover {
    display:inline;
    background:none;   
    margin:0; padding:0;
    color:#333 !important;
    font-size:16px;
    font-family: CalibriRegular, Calibri, Candara, Segoe, 'Segoe UI', Optima, Arial, sans-serif;
}


#footer-content a.site,
#footer-content a.site:hover {
    display:inline-block;
    padding:4px;
    margin:0 auto;
    margin-top:20px;    
    background:#0F565A;   
    color:white !important;
    border-radius:5px;
    padding:10px;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;    
}

#footer-content strong {
    color:#E9A200;
    display:block;
    font-weight:normal;
}

#footer-content hr {
    border-top:1px dotted #666;
}


#footer-content .bottom {
    clear:both;
    border:1px solid red;
}

</style>

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

        <br style="clear:both;" />

    </div>
    <div class="bottom">kk
    
    </div>
</div>


