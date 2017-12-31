<h2><?php echo strftime('%B %Y', $this->date->format('U')); ?></h2>

<? $start = 1; // Monday ?>

<table class="month-calendar" width="100%">
  <tr>
  <?php for( $i=0; $i<7; $i++ ): ?>
    <th class=""><?= strftime('%A',strtotime(sprintf(($start==1?'2007-10':'2008-06').'-%02d',$i+1))) ?></th>
  <?php endfor; ?>
  </tr>

  <?php
  $firstDayOfWeek = $this->date->format($start==1?'N':'w');
  $lastDayOfWeek = date($start==1?'N':'w', strtotime($this->date->format('Y-m-t')));

  if($firstDayOfWeek > $start) {
    echo '<tr>'."\n";
    for($i = $start; $i < $firstDayOfWeek; $i++) {
      echo "\t".'<td class="cal-cell cal-'.($i == 6||$i == 7? 'weekend' : 'weekday').'"></td>'."\n";
    }
  }
  for($i = 1; $i <= $this->date->format('t'); $i++) {
    $thisDay = mktime(0,0,0,$this->month,$i,$this->year);
    if(strftime('%w',$thisDay) == $start)
      echo '</tr>'."\n";

    echo '<td class="cal-cell'
        .( (date('Y-m-d') == date('Y-m-d', $thisDay)) ? ' cal-today':'' )
        .' '.( (date('D', $thisDay) == 'Sat' || date('D', $thisDay) == 'Sun') ? 'cal-weekend' : 'cal-weekday' )
        .'">'."\n";
      
      echo '<div class="cal-day">' . $i . '</div>' . "\n";

      if(array_key_exists($i, $this->calendar)) {
        foreach($this->calendar[$i] as $post) {
          echo '<a href="' . $post->href . '" class="post">';
          if(shouldDisplayPostName($post->title)) {
            echo htmlspecialchars($post->title);
          } else {
            echo display_url($post->href);
          }
          echo '</a>'."\n";
        }
      }

    echo '</td>'."\n";
    if( strftime(($start==1?'%u':'%w'),$thisDay) == ($start==1?7:6) )
      echo '</tr>'."\n";
  }
  if( $lastDayOfWeek < ($start==1?7:6) )
  {
    for( $i=$lastDayOfWeek; $i<($start==1?7:6); $i++ )
    {
      echo '<td class="cal-cell cal-' . ($i==6||$i==5 ? 'weekend' : 'weekday') . '"></td>'."\n";
    }
    echo '</tr>'."\n";
  }
  ?>
</table>

<nav class="months">
  <?php if($this->prev): ?>
    <div class="prev">
      &larr;
      <a href="/<?= $this->lang . '/' . $this->prev->format('Y/m') ?>" rel="prev"><?php echo strftime('%B %Y', $this->prev->format('U')); ?></a>
    </div>
  <?php endif; ?>
  <?php if($this->next): ?>
    <div class="next">
      <a href="/<?= $this->lang . '/' . $this->next->format('Y/m') ?>" rel="next"><?php echo strftime('%B %Y', $this->next->format('U')); ?></a>
      &rarr;
    </div>
  <?php endif; ?>
  <div style="clear:both;"></div>
</nav>

<style>
.month-calendar table { border-collapse: collapse; }
.cal-week, .cal-cell { border: 1px #DFDFDF solid; padding: 2px; }
.cal-week { text-align: center; font-weight: bold; background-color: #EFEFEF; }
.cal-cell { vertical-align: top; height: 120px; width: 14%; }
.cal-day { text-align: right; font-weight: bold; background-color: #EFEFEF; color: #333333; }
.cal-weekend { background-color: #f5f5f5; }
.cal-weekend .cal-day { background-color: #e1e1e1; }
.cal-today { background-color: #FFFFDF; }
.cal-cell .post {
  display: block;
  word-wrap: break-word;
  margin-bottom: 12px;
}
nav.months .prev { float: left; }
nav.months .next { float: right; }
</style>
