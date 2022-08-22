<?php


$box = '<div class="bawp_orange">';
$box .= '<div class="bawp_table" id="bawp_table_' . $table . '" data-id="' . $table . '" data-scroll="' . $scroll . '" data-column_width="' . $column_width . '">';

if( $scroll == 'vertical' ){
  $box .= '<div class="bawp_table_content">';
}else{

  $box .= '<div class="bawp_table_content_mobile' . $table . '">';
  $box .= '<style>';
  $box .= '@media only screen and (max-width: 480px){';
  $box .= '.bawp_table_content_mobile' . $table . '{';
  $box .= 'width:' . (($column_width*$total_products)+($column_width/2) ) . 'px;';
  $box .= '}';
  $box .= '}';
  $box .= '</style>';
}

$box .= '<table border="0" cellpadding="5" cellspacing="1">';


$i = 0;
$have_featured = FALSE;
while( !$have_featured && $i < count($products) ){
  $have_featured = $products[$i]->featured_color;
  $i++;
}

if( $have_featured ){
  $box .= '<tr>';
  $box .= '<td style="border:0"></td>';
  foreach( $products as $product ){
    $box .= '<td class="bawp_featured" style="';
    if( !$product->featured_label ){
      $box .= 'border:0;';
    }
    $box .= '" bgcolor="' . $product->featured_color . '">' . $product->featured_label . '</td>';
  }
  $box .= '</tr>';
}

$total_products = count($products);
  
foreach( $rows as $key_row => $row ){






  
  if( $row->type ){
    $box .= '<tr>';
    $box .= '<td nowrap="nowrap" align="left""><b>';
    $box .= $row->title;
    $box .= '</b></td>';
  }

  

  $index_product = 0;

  foreach( $products as $key_product => $product ){
    
    $index_product++;


    if( $product->featured_color ){


      $split = str_split( str_replace('#', '', $product->featured_color), 2);
      $r = hexdec($split[0]);
      $g = hexdec($split[1]);
      $b = hexdec($split[2]);


      $bgcolor = "rgb(" . $r . ", " . $g . ", " . $b . ", .1)";
    }else{
      $bgcolor = "";
    }

    $aff_url = bawp_affiliate_link( $product->url, $affiliate_id );
    $aff_link_start = '<a href="' . $aff_url . '" target="_blank" class="bawp_button" rel="nofollow">';
    $aff_link_end = '</a>';
      
    $style_width = '';



    switch( $row->type ){

      case 'name':
        $value = $product->name;
        $style_width .= 'word-break: break-word;';
        break;

      case 'description':
        $value = $product->description;
        $style_width .= 'vertical-align:top;text-align:left;word-break: break-word;';
        break;

      case 'photo':
        $value = '<a href="' . $aff_url . '" target="_blank" rel="nofollow" class="bawp_photo"><img src="' . $product->photo . '" width="135" height="135" alt="' . $product->name . '"></a>';
        break;

      case 'rating':
        $value = $product->rating;
        break;
      
      case 'score':
        $value = $product->score;
        break;

      case 'reviews':
        $value = $product->reviews;
        break;

      case 'button_book':
        $value = $aff_link_start . __('Book now', 'bawp') . $aff_link_end;
        break;

      case 'button_price':
        $value = $aff_link_start . __('Show price', 'bawp') . $aff_link_end;
        break;

      case 'button_reviews':
        $value = $aff_link_start . __('Show reviews', 'bawp') . $aff_link_end;
        break;

      case 'button_custom':
        $value = $aff_link_start . $products_rows[ $key_product ][ $key_row ] . $aff_link_end;
        break;

      case 'check':
        if( $products_rows[ $key_product ][ $key_row ] ){
          $value = '✅';
        }else{
          $value = '❌';
        }
        break;
          
      case 'stars':
        $value = '';
        $stars = $products_rows[ $key_product ][ $key_row ];
        if( !$stars ) $stars = $product->stars;
  
        if( $stars ){
          $value = '<span class="bawp_stars">';
          for($i=0; $i<$stars; $i++){
            $value .= '★';
          }
          $value .= '</span>';
        }
        break;
          
      default:
        $value = $products_rows[ $key_product ][ $key_row ];
        break;
    }
    
    if( $row->type ){
      $box .= '<td width="' . $column_width . '" style="background:' . $bgcolor . ';' . $style_width . '" ';

      if( $index_product == $total_products ){
        $box .= 'class="bawp_last"';
      }

      $box .= '>';
      $box .= $value;
      $box .= '</td>';
    }
    
  }


  $box .= '</tr>';
}

$box .= '</table>';
$box .= '</div>';



if( $scroll == 'vertical' ){
  $box .= '<div class="bawp_table_vertical" id="bawp_table_vertical_' . $table . '"></div>';
}


$box .= '</div>';
$box .= '</div>';

?>