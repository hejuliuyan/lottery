<?php
require 'vendor/autoload.php';
use QL\QueryList;

Class index
{

    public function index()
    {
        $opts = array(
            'http' => array(
                'method' => 'GET',
                'header' => "Accept-Encoding: gzip, deflate, sdch\r\n"//在请求的时候告诉服务器支持解Gzip压缩的内容
            )
        );
        $context = stream_context_create($opts);
        $html = file_get_contents('compress.zlib://http://chart.lottery.gov.cn//dltBasicKaiJiangHaoMa.do?typ=1&issueTop=30', false, $context);
//然后可以把页面源码或者HTML片段传给QueryList
        $data = QueryList::Query($html, array(
            //'qi' => array('.Issue','html'),
            'number' => array('.DatRow', 'html', '-.M_2 -.M_3 -.B_3 -.B_2', function ($content) {
                return '<tr class="DatRow" align="center">' . $content . '</tr>';
            })
        ))->data;
        // error_log(print_r($data,true));
        $number_html = '';
        foreach ($data as $val) {
            $number_html .= $val['number'];
        }

//打印结果
        $lie_html = '';
        for ($i = 1; $i < 36; $i++) {
            $lie_html .= '<td title="' . $i . '">' . $i . '</td>';
            // $('.t2').append('<td title="' + i + '">' + i + '</td>');
        }
        for ($i = 1; $i < 13; $i++) {
            $lie_html .= '<td title="' . $i . '">' . $i . '</td>';
            // $('.t2').append('<td title="' + i + '">' + i + '</td>');
        }
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport"
            content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
            <title></title>
            <script src="js/mui.min.js"></script><script src="js/config.js"></script>
            <link href="css/mui.min.css" rel="stylesheet"/>
            <link href="css/chart.css" rel="stylesheet"/>
            <script src="js/jquery-1.7.2.min.js"></script>
            <script src="js/report-function.js"></script>
            <script type="text/javascript" charset="utf-8">
                mui.init();
                $().ready(function(e) {
                });
            </script>
        </head>
        <body scroll=no>
            <table id="reportTable"  freezeRowNum="2" freezeColumnNum="1" class="report" align="center">
                <tbody class="tb">
                <tr class="t1" align="center">
                    <td colspan="1" height="25" width="0">基本数据区</td>
                    <td colspan="35" height="25" width="0">前区号码分布</td>
                    <td colspan="12" height="25" width="0">后区号码分布</td>
                </tr>
                    <tr class="t2" align="center">
                        <td></td>
                        ' . $lie_html . '
                    </tr>
                    ' . $number_html . '
                </tbody>
            </table>
        </body>
        </html>
        ';
        file_put_contents("../Lotto_chart.html", $html);
// echo $number_html;
// error_log(echo($number_html,true));
    }

    /**
     * 七星彩数据采集
     */
    public function Seven_color()
    {
        $opts = array(
            'http' => array(
                'method' => 'GET',
                'header' => "Accept-Encoding: gzip, deflate, sdch\r\n"//在请求的时候告诉服务器支持解Gzip压缩的内容
            )
        );
        $context = stream_context_create($opts);
        $html = file_get_contents('compress.zlib://http://chart.lottery.gov.cn//qxcBasicKaiJiangHaoMa.do?typ=1&issueTop=30', false, $context);
//然后可以把页面源码或者HTML片段传给QueryList

        $data = QueryList::Query($html, array(
            'number' => array('.DatRow', 'html', '-.fc333 .fgx -.borbottom -.dotlitt', function ($content) {
                $i = 1;
                if ($content != '<td colspan="500"></td>') {
                    return '<tr class="DatRow tr' . $i++ . '" align="center">' . $content . '</tr>';
                }
                // return $content;
            })
        ))->data;
        //  error_log(print_r($data,true));
        $lie_html = '';
        foreach ($data as $k => $val) {
            $lie_html .= $val['number'];
        }
        $td = '';
        for ($i = 0; $i < 10; $i++) {
            $td .= '<td title="' . $i . '">' . $i . '</td>';
        }
        $html_show = '
          <!DOCTYPE html>
          <html>
          <head>
              <meta charset="utf-8">
              <meta name="viewport"
              content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
              <title></title>
              <script src="js/mui.min.js"></script><script src="js/config.js"></script>
              <link href="css/mui.min.css" rel="stylesheet"/>
              <link href="css/scol_chart.css" rel="stylesheet"/>
              <script src="js/jquery-1.7.2.min.js"></script>
              <script src="js/report-function.js"></script>
              <script type="text/javascript" charset="utf-8">
                  mui.init();
                  $().ready(function(e) {
                  });
              </script>
          </head>
          <body scroll=no>
              <table id="reportTable"  freezeRowNum="2" freezeColumnNum="1" class="report" align="center">
                  <tbody class="tb">
                  <tr class="t1" align="center">
				<td colspan="1" height="25" width="0">基本数据区</td>
				<td colspan="10" height="25" width="0">第1位</td>
				<td colspan="10" height="25" width="0">第2位</td>
				<td colspan="10" height="25" width="0">第3位</td>
				<td colspan="10" height="25" width="0">第4位</td>
				<td colspan="10" height="25" width="0">第5位</td>
				<td colspan="10" height="25" width="0">第6位</td>
				<td colspan="10" height="25" width="0">第7位</td>
			</tr>
			<tr class="t2" align="center">
				<td title="期号">期号</td>
				'.$td.$td.$td.$td.$td.$td.$td.'
				</tr>
                          ' . $lie_html . '
                  </tbody>
              </table>
          </body>
          </html>
          ';
        file_put_contents("../Scolor_chart.html", $html_show);
    }

    /**
     * rank_three
     */
    public function rank_three()
    {
        $opts = array(
            'http' => array(
                'method' => 'GET',
                'header' => "Accept-Encoding: gzip, deflate, sdch\r\n"//在请求的时候告诉服务器支持解Gzip压缩的内容
            )
        );
        $context = stream_context_create($opts);
        $html = file_get_contents('compress.zlib://http://chart.lottery.gov.cn//pl3BasicKaiJiangHaoMa.do?typ=1&issueTop=30', false, $context);
//然后可以把页面源码或者HTML片段传给QueryList
        $data = QueryList::Query($html, array(
            // 'qi' => array('#content','html')
            'number' => array('.DatRow', 'html', '-.M_2 -.M_1 -.B_1 -.B_2 -.M_3 -.B_3 -.borbottom -.dotlitt', function ($content) {
                if ($content != '<td colspan="500"></td>') {
                    $i = 1;
                    return '<tr class="DatRow tr' . $i++ . '" align="center">' . $content . '</tr>';
                }
            })
        ))->data;
//        error_log(print_r($data, true));
        $lie_html = '';
        foreach ($data as $k => $val) {
            $lie_html .= $val['number'];
        }
        $xh = '';
        for ($i = 0; $i < 10; $i++) {
            $xh .= '<td title="' . $i . '">' . $i . '</td>';
        }

        $html_show = '
          <!DOCTYPE html>
          <html>
          <head>
              <meta charset="utf-8">
              <meta name="viewport"
              content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
              <title></title>
              <script src="js/mui.min.js"></script><script src="js/config.js"></script>
              <link href="css/mui.min.css" rel="stylesheet"/>
              <link href="css/scol_chart.css" rel="stylesheet"/>
              <script src="js/jquery-1.7.2.min.js"></script>
              <script src="js/report-function.js"></script>
              <script type="text/javascript" charset="utf-8">
                  mui.init();
                  $().ready(function(e) {
                  });
              </script>
          </head>
          <body scroll=no>
              <table id="reportTable"  freezeRowNum="2" freezeColumnNum="1" class="report" align="center">
                  <tbody class="tb">
                  <tr class="t1" align="center">
				<td colspan="1" height="25" width="0">基本数据区</td>
				<td colspan="10" height="25" width="0">百位</td>
				<td colspan="10" height="25" width="0">十位</td>
				<td colspan="10" height="25" width="0">个位</td>
			</tr>
			    <tr class="t2" align="center">
			    <td></td>
			        ' . $xh . $xh . $xh . '
                </tr>
                          ' . $lie_html . '
                  </tbody>
              </table>
          </body>
          </html>
          ';
        file_put_contents("../Rthree_chart.html", $html_show);

    }

    /**
     * 排列五走势图
     */
    public function rank_five()
    {
        $opts = array(
            'http' => array(
                'method' => 'GET',
                'header' => "Accept-Encoding: gzip, deflate, sdch\r\n"//在请求的时候告诉服务器支持解Gzip压缩的内容
            )
        );
        $context = stream_context_create($opts);
        $html = file_get_contents('compress.zlib://http://chart.lottery.gov.cn//pl5BasicKaiJiangHaoMa.do?typ=1&issueTop=30', false, $context);
//然后可以把页面源码或者HTML片段传给QueryList
        $data = QueryList::Query($html, array(
            // 'qi' => array('#content','html')
            'number' => array('.DatRow', 'html', '-.fc333 -.borbottom -.dotlitt -.KjCode', function ($content) {
                if ($content != '<td colspan="500"></td>') {
                    $i = 1;
                    return '<tr class="DatRow tr' . $i++ . '" align="center">' . $content . '</tr>';
                }
            })
        ))->data;
//        error_log(print_r($data, true));
        $lie_html = '';
        foreach ($data as $k => $val) {
            $lie_html .= $val['number'];
        }

        $xh = '';
        for ($i = 0; $i < 10; $i++) {
            $xh .= '<td title="' . $i . '">' . $i . '</td>';
        }
        $html_show = '
          <!DOCTYPE html>
          <html>
          <head>
              <meta charset="utf-8">
              <meta name="viewport"
              content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
              <title></title>
              <script src="js/mui.min.js"></script><script src="js/config.js"></script>
              <link href="css/mui.min.css" rel="stylesheet"/>
              <link href="css/scol_chart.css" rel="stylesheet"/>
              <script src="js/jquery-1.7.2.min.js"></script>
              <script src="js/report-function.js"></script>
              <script type="text/javascript" charset="utf-8">
                  mui.init();
                  $().ready(function(e) {
                  });
              </script>
          </head>
          <body scroll=no>
              <table id="reportTable"  freezeRowNum="2" freezeColumnNum="1" class="report" align="center">
                  <tbody class="tb">
                  <tr class="t1" align="center">
				<td colspan="1" height="25" width="0"></td>
				<td colspan="10" height="25" width="0">第1位</td>
				<td colspan="10" height="25" width="0">第2位</td>
				<td colspan="10" height="25" width="0">第3位</td>
				<td colspan="10" height="25" width="0">第4位</td>
				<td colspan="10" height="25" width="0">第5位</td>
			</tr>
			<tr class="t2" align="center">
				<td title="期号">期号</td>

				' . $xh . $xh . $xh . $xh . $xh . '
				</tr>
                          ' . $lie_html . '
                  </tbody>
              </table>
          </body>
          </html>
          ';
        file_put_contents("../Rfive_chart.html", $html_show);
    }


}

$obj = new index();
$obj->index();
$obj->Seven_color();
$obj->rank_three();
$obj->rank_five();
