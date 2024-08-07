<?php
    get_header();  

    while(have_posts()) {
        the_post(); 
        pageBanner();
        ?>
        
        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('member');?>">
                    <i class="fa fa-home" aria-hidden="true"></i> Alle Spieler
                    </a> 
                    <span class="metabox__main"><?php the_title(); ?></span>
                </p>
            </div>
            <div class="generic-content">
                <div class="row group">
                    <div class="one-third">
<?php                   the_post_thumbnail('memberPortrait'); ?>
                    </div>
                    <div class="two-thirds">
<?php                   the_content(); ?>
                    </div>
                </div>
                <div class="row group">
                    <div id="chart_div" style="width: 900px; height: 500px"></div>
                </div>
            </div>
<?php       $relatedTeam = get_field('related_team');
                
                if ($relatedTeam) {
                    echo '<hr class="section-break">';
                    echo '<h2 class="headline headline--medium">Spielt in:</h2>';
                    echo '<ul class="link-list min-list">';
                    foreach($relatedTeam as $team) { ?>
                        <li><a href="<?php echo get_the_permalink($team); ?>"><?php echo get_the_title($team); ?></a></li>
<?php               } 
                    echo '</ul>'; 
                } 
                $gesamt = 30;
                ?>
        </div>
        <script> 
      google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawLineColors);

function drawLineColors() {
      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Spiel');
      data.addColumn('number', 'Gesamt');
      data.addColumn('number', 'Volle');
      data.addColumn('number', 'Abräumen');

      data.addRows([
        [new Date(2024, 4, 7), <?php echo $gesamt; ?>, 12, 40],    [new Date(2024, 4, 8), 10, 5, 5],   [new Date(2024, 4, 9), 23, 15, 23],  
        [new Date(2024, 4, 10), 17, 9, 21],   [new Date(2024, 4, 11), 18, 10, 21],  [new Date(2024, 4, 12), 9, 5, 21],
        [new Date(2024, 4, 13), 11, 3, 21],   [new Date(2024, 4, 14), 27, 19, 21],  [new Date(2024, 4, 15), 33, 25, 21],  
        [new Date(2024, 4, 16), 40, 32, 21],  [new Date(2024, 4, 17), 32, 24, 21], [new Date(2024, 4, 18), 35, 27, 21],
        [new Date(2024, 4, 19), 30, 22, 21], [new Date(2024, 4, 20), 40, 32, 21], [new Date(2024, 4, 21), 42, 34, 21], 
        [new Date(2024, 4, 22), 47, 39, 21], [new Date(2024, 4, 23), 44, 36, 21], [new Date(2024, 4, 24), 48, 40, 21],
        [new Date(2024, 4, 25), 52, 44, 21], [new Date(2024, 4, 26), 54, 46, 21], [new Date(2024, 4, 27), 42, 34, 21], 
        [new Date(2024, 5, 7), 55, 47, 21], [new Date(2024, 5, 8), 56, 48, 21], [new Date(2024, 5, 9), 57, 49, 21]
      ]);

      var options = {
        hAxis: {
          title: 'Spiele'
        },
        vAxis: {
          title: 'Kegel'
        },
        colors: ['#a52714', '#097138', '#798FE7']
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
</script>
<?php }
    get_footer();
?>