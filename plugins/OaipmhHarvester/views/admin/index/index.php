<?php
/**
 * Admin index view.
 * 
 * @package OaipmhHarvester
 * @subpackage Views
 * @copyright Copyright (c) 2009-2011 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

$head = array('title'      => 'OAI-PMH Harvester',
              'body_class' => 'primary oaipmh-harvester');
echo head($head);
?>
<style type="text/css">
.base-url, .harvest-status {
    white-space: nowrap;
}

.base-url div{
    max-width: 18em;
    overflow: hidden;
    text-overflow: ellipsis;
}

.harvest-status input[type="submit"] {
    margin: .25em 0 0 0;
}

#ok {
    display:none;
}
</style>

<script>
jQuery(document).ready(function() {

    jQuery('.days').change(function() {
        var formId = jQuery(this).closest("form").attr('id');
        if(this.value != '') {
            jQuery('#'+formId +' > .hours').show();
        } else {
            jQuery('#'+formId +' > .hours').hide();
        }
        jQuery('#'+formId +' [name="ok"]').show();
    });

    jQuery('.hours').change(function() {
        var formId = jQuery(this).closest("form").attr('id');
        jQuery('#'+formId +' [name="ok"]').show();
    });
});
</script>

<div id="primary">

<?php echo flash(); ?>
    <h2>Data Provider</h2>
    <?php echo $this->harvestForm; ?> 
    <br/>
    <div id="harvests">
    <h2>Harvests</h2>
    <?php if (empty($this->harvests)): ?>
    <p>There are no harvests.</p>
    <?php else: ?>
    <table>
       <thead>
            <tr>
                <th>Base URL</th>
                <th>Metadata Prefix</th>
                <th>Set</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($this->harvests as $harvest): ?>
            <?php
                error_reporting(0);
                unset($days, $hours);
                if (empty($harvest->day) && $harvest->day != 0)
                    $days['non'] = 'selected';
                else    
                    $days[$harvest->day] = 'selected';
                $hours[$harvest->hour] = 'selected';
            ?>
            <tr>
                <td title="<?php echo html_escape($harvest->base_url); ?>" class="base-url">
                    <div><?php echo html_escape($harvest->base_url); ?></div>
                    <form id="<?php echo $harvest->id?>" method="post" action="<?php echo url('oaipmh-harvester/index/automated');?>">
                        <b>Automatique : </b>
                        <select name="day" class="days">
                        <?php print_r($days) ?>
                            <option <?php echo $days['non']?> value="">non</option>
                            <option <?php echo $days[1]?> value="1">le lundi</option>
                            <option <?php echo $days[2]?> value="2">le mardi</option>
                            <option <?php echo $days[3]?> value="3">le mercredi</option>
                            <option <?php echo $days[4]?> value="4">le jeudi</option>
                            <option <?php echo $days[5]?> value="5">le vendredi</option>
                            <option <?php echo $days[6]?> value="6">le samedi</option>
                            <option <?php echo $days[0]?> value="0">le dimanche</option>
                        </select>
                        <span class="hours" style="display:<?php echo $harvest->hour > 0 ? 'inline' : 'none'?>">
                            <b>à</b>
                            <select name="hour">
                                <?php for($i=1 ; $i <24 ; $i++): ?>
                                <option <?php echo $hours[$i]?> value="<?php echo $i ?>"><?php echo sprintf("%02d", $i) ?></option>
                                <?php endfor; ?>
                            </select>&nbsp;<b>heures</b>&nbsp;
                            <?php echo $this->formHidden('harvest_id', $harvest->id); ?>
                        </span>
                        <?php echo $this->formSubmit('ok', 'OK'); ?>    
                    </form>

                </td>
                <td><?php echo html_escape($harvest->metadata_prefix); ?></td>
                <td>
                    <?php
                    if ($harvest->set_spec):
                        echo html_escape($harvest->set_name)
                            . ' (' . html_escape($harvest->set_spec) . ')';
                    else:
                        echo '[Entire Repository]';
                    endif;
                    ?>
                </td>
                <td class="harvest-status">
                    <a href="<?php echo url("oaipmh-harvester/index/status?harvest_id={$harvest->id}"); ?>"><?php echo html_escape(ucwords($harvest->status)); ?></a>
                    <?php if ($harvest->status == OaipmhHarvester_Harvest::STATUS_COMPLETED): ?>
                        <br>
                        <form method="post" action="<?php echo url('oaipmh-harvester/index/harvest');?>">
                        <?php echo $this->formHidden('harvest_id', $harvest->id); ?>
                        <?php echo $this->formSubmit('submit_reharvest', 'Re-Harvest'); ?>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
    </div>
</div>
<?php echo foot(); ?>
