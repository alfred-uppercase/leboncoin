
<div class="opening">
  <div class="ribbon">
    <span class="<?php echo strtolower(now_open($listing_id)) == 'closed' ? 'closed' : 'open'; ?>"><?php echo now_open($listing_id); ?></span>
  </div>
  <i class="icon_clock_alt"></i>
  <h4><?php echo get_phrase('opening_hours'); ?></h4>
  <?php $time_config = $this->db->get_where('time_configuration', array('listing_id' => $listing_id))->row_array();?>
  <div class="row">
    <div class="col-md-6">
      <ul>
        <li>
          <?php echo get_phrase('saturday'); ?>
          <span>
            <?php echo oc_time($time_config['saturday']); ?>
          </span>
        </li>
        <li>
          <?php echo get_phrase('sunday'); ?>
          <span>
            <?php echo oc_time($time_config['sunday']); ?>
            
          </span>
        </li>
        <li>
          <?php echo get_phrase('monday'); ?>
          <span>
            <?php echo oc_time($time_config['monday']); ?>
            
          </span>
        </li>
        <li>
          <?php echo get_phrase('tuesday'); ?>
          <span>
            <?php echo oc_time($time_config['tuesday']); ?>
            
          </span>
        </li>
      </ul>
    </div>
    <div class="col-md-6">
      <ul>
        <li>
          <?php echo get_phrase('wednesday'); ?>
          <span>
            <?php echo oc_time($time_config['wednesday']); ?>
            
          </span>
        </li>
        <li>
          <?php echo get_phrase('thursday'); ?>
          <span>
          <?php echo oc_time($time_config['thursday']); ?>
           
          </span>
        </li>
        <li>
          <?php echo get_phrase('friday'); ?>
          <span>
          <?php echo oc_time($time_config['friday']); ?>
            
          </span>
        </li>
      </ul>
    </div>
  </div>
</div>
