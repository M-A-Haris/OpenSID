<style type="text/css">
/*@import 'https://code.highcharts.com/css/highcharts.css';*/
.highcharts-figure, .highcharts-data-table table {
    min-width: 360px;
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}
#container {
    min-width: 300px;
    overflow: scroll !important;
}
#container h4 {
    text-transform: none;
    font-size: 10px;
    font-weight: normal;
}
#container p {
    font-size: 10px;
    line-height: 10px;
}

@media screen and (max-width: 600px) {
    #container h4 {
        font-size: 2.3vw;
        line-height: 3vw;
    }
    #container p {
        font-size: 2.3vw;
        line-height: 3vw;
    }
}
</style>

<div class="content-wrapper">
	<section class="content" id="maincontent">
		<div class="row">
			<div class="col-md-12">
					<div class="box-body">
						<figure class="highcharts-figure">
						    <div id="container"></div>
						    <p class="highcharts-description">
						    </p>
						</figure>
					</div>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        height: 600,
        width: 800,
        inverted: true
    },

    title: {
        text: 'Struktur Organisasi Pemerintahan <?= ucwords($this->setting->sebutan_desa.' '.$desa['nama_desa'])?>'
    },

    accessibility: {
        point: {
            descriptionFormatter: function (point) {
                var nodeName = point.toNode.name,
                    nodeId = point.toNode.id,
                    nodeDesc = nodeName === nodeId ? nodeName : nodeName + ', ' + nodeId,
                    parentDesc = point.fromNode.id;
                return point.index + '. ' + nodeDesc + ', reports to ' + parentDesc + '.';
            }
        }
    },

    series: [{
        type: 'organization',
        name: "<?= ucwords($this->setting->sebutan_desa.' '.$desa['nama_desa'])?>",
        keys: ['from', 'to'],
        data: [
          ['BPD','LPM'],
   				<?php foreach ($bagan['struktur'] as $struktur): ?>
						[<?= key($struktur) ?>,<?= current($struktur)?>],
					<?php endforeach;?>
        ],
        levels: [{
            level: 0,
            color: 'gold',
            dataLabels: {
                color: 'black'
            },
            height: 25
        }, {
            level: 1,
            color: 'MediumTurquoise',
            dataLabels: {
                color: 'white'
            },
            height: 25
        }, {
            level: 2,
            color: '#980104',
            dataLabels: {
                color: 'white'
            },
            height: 25
        }, {
            level: 4,
            color: '#359154',
            dataLabels: {
                color: 'white'
            },
            height: 25
        }],

        linkColor: "#ccc",
        linkLineWidth: 2,
        linkRadius: 0,

        nodes: [
          {
              id: 'BPD',
              color: 'gold',
              column: 0,
              offset: '-150'
          },
          {
              id: 'LPM',
              color: 'gold',
              column: 0,
              dataLabels: {
                  color: 'black'
              },
              offset: '150'
          },
        	<?php foreach ($bagan['nodes'] as $pamong) : ?>
        		{
        			id: <?= $pamong['pamong_id']?>,
        			title: '<?= $pamong['jabatan']?>',
        			name: "<?= $pamong['nama']?>",
                    <?php if (! empty($pamong['foto'])): ?>
            			image: '<?= base_url().LOKASI_USER_PICT.'kecil_'.$pamong['foto']?>',
                    <?php endif; ?>
        			<?php if (! empty($pamong['bagan_tingkat'])): ?>
        				column: <?= $pamong['bagan_tingkat'] ?: ''?>,
        			<?php endif; ?>
        			<?php if (! empty($pamong['bagan_offset'])): ?>
        				offset: '<?= $pamong['bagan_offset'] ?: ''?>%',
        			<?php endif; ?>
        			<?php if (! empty($pamong['bagan_layout'])): ?>
        				layout: '<?= $pamong['bagan_layout'] ?: ''?>',
        			<?php endif; ?>
                    <?php if (! empty($pamong['bagan_warna'])): ?>
                        color: '<?= $pamong['bagan_warna'] ?: ''?>',
                    <?php endif; ?>
        		},
        	<?php endforeach; ?>
        ],
        colorByPoint: false,
        color: '#007ad0',
        dataLabels: {
            color: 'white'
        },
        shadow: {
          color: '#ccc',
          width: 10,
          offsetX: 0,
          offsetY: 0
        },
        borderColor: 'white',
        nodeWidth: 75
    }],
    tooltip: {
        outside: true
    },
    exporting: {
        allowHTML: true,
        sourceWidth: 800,
        sourceHeight: 600
    }

});

</script>
