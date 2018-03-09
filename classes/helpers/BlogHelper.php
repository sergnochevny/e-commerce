<?php
/**
 * Date: 09.03.2018
 * Time: 12:33
 */

namespace classes\helpers;

use app\core\App;

class BlogHelper{

  /**
   * @param $pee
   * @param bool $br
   * @return null|string|string[]
   */
  private static function autop($pee, $br = true){
    $pre_tags = [];

    if(trim($pee) === '') return '';

    $pee = $pee . "\n";
    if(strpos($pee, '<pre') !== false) {
      $pee_parts = explode('</pre>', $pee);
      $last_pee = array_pop($pee_parts);
      $pee = '';
      $i = 0;

      foreach($pee_parts as $pee_part) {
        $start = strpos($pee_part, '<pre');
        if($start === false) {
          $pee .= $pee_part;
          continue;
        }

        $name = "<pre wp-pre-tag-$i></pre>";
        $pre_tags[$name] = substr($pee_part, $start) . '</pre>';

        $pee .= substr($pee_part, 0, $start) . $name;
        $i++;
      }

      $pee .= $last_pee;
    }
    $pee = preg_replace('|<br\s*/?>\s*<br\s*/?>|', "\n\n", $pee);

    $allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
    $unaryblocks = '(?:img)';
    $pee = preg_replace('!(<' . $allblocks . '[\s/>])!', "\n$1", $pee);
    $pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
    $pee = str_replace(["\r\n", "\r"], "\n", $pee);
    $pee = static::replace_in_html_tags($pee, ["\n" => " <!-- wpnl --> "]);
    if(strpos($pee, '<option') !== false) {
      $pee = preg_replace('|\s*<option|', '<option', $pee);
      $pee = preg_replace('|</option>\s*|', '</option>', $pee);
    }
    if(strpos($pee, '</object>') !== false) {
      $pee = preg_replace('|(<object[^>]*>)\s*|', '$1', $pee);
      $pee = preg_replace('|\s*</object>|', '</object>', $pee);
      $pee = preg_replace('%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $pee);
    }
    if(strpos($pee, '<source') !== false || strpos($pee, '<track') !== false) {
      $pee = preg_replace('%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $pee);
      $pee = preg_replace('%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $pee);
      $pee = preg_replace('%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $pee);
    }
    $pee = preg_replace("/\n\n+/", "\n\n", $pee);
//      $pee = preg_replace('|<p>\s*</p>|', '', $pee);
    $pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
    $pee = '';
    foreach($pees as $tinkle) {
      $pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
    }
    $pee = preg_replace('|<p>\s*</p>|', '', $pee);
    $pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
    $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
    $pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee);
    $pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
    $pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
    $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
    $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
    $pee = preg_replace('!<p>\s*(<' . $unaryblocks . '[^>]*/>)!', "$1", $pee);
    $pee = preg_replace('!(<' . $unaryblocks . '[^>]*/>)\s*</p>!', "$1", $pee);
    if($br) {
      $pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', [
        'static',
        '_autop_newline_preservation_helper'
      ], $pee);
      $pee = str_replace(['<br>', '<br/>'], '<br />', $pee);
      $pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee);
      $pee = str_replace('<WPPreserveNewline />', "\n", $pee);
    }
    $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
    $pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
    $pee = preg_replace("|\n</p>$|", '</p>', $pee);
    if(!empty($pre_tags)) $pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);
    if(false !== strpos($pee, '<!-- wpnl -->')) {
      $pee = str_replace([' <!-- wpnl --> ', '<!-- wpnl -->'], "\n", $pee);
    }

    return $pee;
  }

  /**
   * @param $haystack
   * @param $replace_pairs
   * @return string
   */
  private static function replace_in_html_tags($haystack, $replace_pairs){
    // Find all elements.
    $textarr = static::html_split($haystack);
    $changed = false;
    if(1 === count($replace_pairs)) {
      foreach($replace_pairs as $needle => $replace)
        for($i = 1, $c = count($textarr); $i < $c; $i += 2) {
          if(false !== strpos($textarr[$i], $needle)) {
            $textarr[$i] = str_replace($needle, $replace, $textarr[$i]);
            $changed = true;
          }
        }
    } else {
      $needles = array_keys($replace_pairs);
      for($i = 1, $c = count($textarr); $i < $c; $i += 2) {
        foreach($needles as $needle) {
          if(false !== strpos($textarr[$i], $needle)) {
            $textarr[$i] = strtr($textarr[$i], $replace_pairs);
            $changed = true;
            break;
          }
        }
      }
    }

    if($changed) {
      $haystack = implode($textarr);
    }

    return $haystack;
  }

  /**
   * @param $input
   * @return array[]|false|string[]
   */
  private static function html_split($input){
    return preg_split(static::html_split_regex(), $input, -1, PREG_SPLIT_DELIM_CAPTURE);
  }

  /**
   * @return string
   */
  private static function html_split_regex(){
    static $regex;

    if(!isset($regex)) {
      $comments = '!'           // Start of comment, after the <.
        . '(?:'         // Unroll the loop: Consume everything until --> is found.
        . '-(?!->)' // Dash not followed by end of comment.
        . '[^\-]*+' // Consume non-dashes.
        . ')*+'         // Loop possessively.
        . '(?:-->)?';   // End of comment. If not found, match all input.

      $cdata = '!\[CDATA\['  // Start of comment, after the <.
        . '[^\]]*+'     // Consume non-].
        . '(?:'         // Unroll the loop: Consume everything until ]]> is found.
        . '](?!]>)' // One ] not followed by end of comment.
        . '[^\]]*+' // Consume non-].
        . ')*+'         // Loop possessively.
        . '(?:]]>)?';   // End of comment. If not found, match all input.

      $escaped = '(?='           // Is the element escaped?
        . '!--' . '|' . '!\[CDATA\[' . ')' . '(?(?=!-)'      // If yes, which type?
        . $comments . '|' . $cdata . ')';

      $regex = '/('              // Capture the entire match.
        . '<'           // Find start of element.
        . '(?'          // Conditional expression follows.
        . $escaped  // Find end of escaped element.
        . '|'           // ... else ...
        . '[^>]*>?' // Find end of normal element.
        . ')' . ')/';
    }

    return $regex;
  }

  /**
   * @param $matches
   * @return mixed
   */
  private static function _autop_newline_preservation_helper($matches){
    return str_replace("\n", "<WPPreserveNewline />", $matches[0]);
  }

  /**
   * @param $txt
   * @return mixed|null|string|string[]
   * @throws \Exception
   */
  public static function convertation($txt){

//        $txt = preg_replace('#(\s*\[caption[^\]]+\]<a[^>]+><img[^>]+\/><\/a>)(.*?)(\[\/caption\]\s*)#i', '$1<p>$2</p>$3', $txt);
//        $txt = preg_replace('#\[caption([^\]]+)\]#i', '<div$1 class="div_img">', $txt);
//        $txt = preg_replace('#\[\/caption\]#i', '</div>', $txt);
//        $txt = preg_replace('#<a[^>]+>(<img[^>]+\/>)<\/a>#i', '$1', $txt);
//        $txt = preg_replace('#\s*<a[^>]+href ?= ?"http:\/\/www.iluvfabrix[^><]+>(.*)<\/a>\s*#isU', '$1', $txt);
//        $txt = str_replace('http://iluvfabrix.com/blog/wp-content/uploads', '{base_url}/img', $txt);
//        $txt = str_replace('http://www.iluvfabrix.com/blog/wp-content/uploads', '{base_url}/img', $txt);
//        $txt = str_replace('http://iluvfabrix.com', '{base_url}', $txt);

    $txt = str_replace(App::$app->router()->UrlTo('/'), '{base_url}', $txt);
    $txt = str_replace('http://www.iluvfabrix.com', '{base_url}', $txt);
    $txt = preg_replace('#[^ \.]*\.iluvfabrix\.com#i', '{base_url}', $txt);
    $txt = str_replace('{base_url}/', '{base_url}', $txt);
    $txt = str_replace(['‘', '’'], "'", $txt);
    $txt = str_replace(" ", " ", $txt);
    $txt = str_replace('–', "-", $txt);
    $txt = preg_replace('#[^\x{00}-\x{7f}]#i', '', $txt);

    $txt = static::autop($txt);

    return $txt;
  }
}