<?php

session_start();

define('LF', chr(10));/* 改行コード */

// ini_set('display_errors', 1);/* エラー内容表示 */

$escape = '';

if (isset($_POST['is_delete']) || empty($_POST['is_post'])) {
    $_SESSION['break_sp'] = "";/* セッション */
    $_SESSION['break_tab'] = "";
    $_SESSION['path'] = "";
    $_SESSION['wp'] = "wp";
    $_SESSION['webp'] = "webp";
    $_SESSION['retina'] = "retina";
}
if (isset($_POST['is_post'])) {/* ボタンを押すまで以下は読み込まない 　isset値があるかどうか　本当はhttpMethodがpostのときに実行のほうがスマート*/

    $alt = $_POST['alt'];/* フォーム内のname属性alt取得 */
    $sp = $_POST['break_sp'];
    $tab = $_POST['break_tab'];
    $load = $_POST['loading'];

    $_SESSION['break_sp'] = $_POST['break_sp'];/* セッション */
    $_SESSION['break_tab'] = $_POST['break_tab'];
    $_SESSION['path'] = $_POST['path'];

    $wp = '';
    if (isset($_POST['wp']) && $_POST['wp'] == 'wp') {
        // checked
        $wp = $_POST['wp'];
        $_SESSION['wp'] = 'wp';
    } else {
        // uncheked
        $_SESSION['wp'] = '';
    }
    $webp = '';
    if (isset($_POST['webp'])) {
        $webp = $_POST['webp'];
        $_SESSION['webp'] = 'webp';
    } else {
        $_SESSION['webp'] = '';
    }
    $retina = '';
    if (isset($_POST['retina'])) {
        $retina = $_POST['retina'];
        $_SESSION['retina'] = 'retina';
    } else {
        $_SESSION['retina'] = '';
    }


    $midpath = $_POST['path'];

    $img_rocal = $_FILES["img"]["tmp_name"];
    $_SESSION['img'] = $_FILES["img"]["tmp_name"];

    if ($img_rocal != '') {
        $imagedata2 = getimagesize($img_rocal);/* アップした画像の幅、高さ取得 */
    }
    $exe = explode("/", $imagedata2['mime']);
    if ($exe[1] == 'jpeg') {
        if (!strstr($_FILES["img"]["name"], '.jpeg')) {
            $extention = str_replace('jpeg', 'jpg', $exe[1]);/* これを変えるそれから */
            $filename = str_replace('.jpg', '', $_FILES["img"]["name"]);/* これを変えるそれから */
        } else {
            $extention = $exe[1];
            $filename = str_replace('.' . $exe[1], '', $_FILES["img"]["name"]);/* これを変えるそれから */
        }
    } else {
        $filename = str_replace('.' . $exe[1], '', $_FILES["img"]["name"]);/* これを変えるそれから */
        $extention = $exe[1];
    }

    $wp_act = '';
    if ($wp != '') {
        $wp_act = '<?php echo get_stylesheet_directory_uri(); ?>/';
    }

    $webp_act = '';
    $webp_act2 = '';
    $webp_act3 = '';
    if ($webp != '') {
        $webp_act = 'webp/';
        $webp_act2 = 'webp';
        $webp_act3 = ' type="image/webp"';
    } else {
        $webp_act2 = $extention;
    }

    $command = 'python3 commpress.py ' . $_FILES["img"]['tmp_name'] . ' ' . $filename . '.' . $exe[1];
    
    exec($command, $output);

    $html = '';/* 変数の初期化 */
    $html .= '<picture>' . LF;/* $html = $html . '<picture>';の省略バージョン */

    if ($sp != '') {
        if ($retina != '') {
            if ($webp != '') {
                $html .= '<source media="(max-width:' . $sp . 'px)"' . $webp_act3 . ' srcset="' . $wp_act . 'img/' . $webp_act . '' . $filename . '_sp.' . $webp_act2 . ' 1x,' . $wp_act . 'img/' . $webp_act . '' . $filename . '_sp@2x.' . $webp_act2 . ' 2x">' . LF;
                $html .= '<source media="(max-width:' . $sp . 'px)" srcset="' . $wp_act . 'img/' . $midpath . '' . $filename . '_sp.' . $extention  . ' 1x,' . $wp_act . 'img/' . $midpath . '' . $filename . '_sp@2x.' . $extention  . ' 2x">' . LF;
            } else {
                $html .= '<source media="(max-width:' . $sp . 'px)" srcset="' . $wp_act . 'img/' . $midpath . '' . $filename . '_sp.' . $extention  . ' 1x,' . $wp_act . 'img/' . $midpath . '' . $filename . '_sp@2x.' . $extention  . ' 2x">' . LF;
            }
        } else {
            if ($webp != '') {
                $html .= '<source media="(max-width:' . $sp . 'px)"' . $webp_act3 . ' srcset="' . $wp_act . 'img/' . $webp_act . '' . $filename . '_sp.' . $webp_act2 . '">' . LF;
                $html .= '<source media="(max-width:' . $sp . 'px)" srcset="' . $wp_act . 'img/' . $midpath . '' . $filename . '_sp.' . $extention  . '">' . LF;
            } else {
                $html .= '<source media="(max-width:' . $sp . 'px)" srcset="' . $wp_act . 'img/' . $midpath . '' . $filename . '_sp.' . $extention  . '">' . LF;
            }
        }
    }
    if ($tab != '') {
        if ($retina != '') {
            if ($webp != '') {
                $html .= '<source media="(max-width:' . $tab . 'px)"' . $webp_act3 . ' srcset="' . $wp_act . 'img/' . $webp_act . '' . $filename . '_tab.' . $webp_act2 . ' 1x,' . $wp_act . 'img/' . $webp_act . '' . $filename . '_tab@2x.' . $webp_act2 . ' 2x">' . LF;
                $html .= '<source media="(max-width:' . $tab . 'px)" srcset="' . $wp_act . 'img/' . $midpath . '' . $filename . '_tab.' . $extention  . ' 1x,' . $wp_act . 'img/' . $midpath . '' . $filename . '_tab@2x.' . $extention  . ' 2x">' . LF;
            } else {
                $html .= '<source media="(max-width:' . $tab . 'px)" srcset="' . $wp_act . 'img/' . $midpath . '' . $filename . '_tab.' . $extention  . ' 1x,' . $wp_act . 'img/' . $midpath . '' . $filename . '_tab@2x.' . $extention  . ' 2x">' . LF;
            }
        } else {
            if ($webp != '') {
                $html .= '<source media="(max-width:' . $tab . 'px)"' . $webp_act3 . ' srcset="' . $wp_act . 'img/' . $webp_act . '' . $filename . '_tab.' . $webp_act2 . '">' . LF;
                $html .= '<source media="(max-width:' . $tab . 'px)" srcset="' . $wp_act . 'img/' . $midpath . '' . $filename . '_tab.' . $extention  . '">' . LF;
            } else {
                $html .= '<source media="(max-width:' . $tab . 'px)" srcset="' . $wp_act . 'img/' . $midpath . '' . $filename . '_tab.' . $extention  . '">' . LF;
            }
        }
    }
    if ($retina != '') {
        if ($webp != '') {
            $html .= '<source' . $webp_act3 . ' srcset="' . $wp_act . 'img/' . $webp_act . '' . $filename . '.' . $webp_act2 . ' 1x,' . $wp_act . 'img/' . $webp_act . '' . $filename . '@2x.' . $webp_act2 . ' 2x">' . LF;
            if ($load == 'none') {
                $html .= '<img src="' . $wp_act . 'img/' . $midpath . '' . $filename . '.' . $extention  . '" srcset="' . $wp_act . 'img/' . $midpath . '' . $filename . '.' . $extention  . ' 1x,' . $wp_act . 'img/' . $midpath . '' . $filename . '@2x.' . $extention  . ' 2x" alt="' . $alt . '" ' . $imagedata2[3] . '">' . LF;
            } else {
                $html .= '<img src="' . $wp_act . 'img/' . $midpath . '' . $filename . '.' . $extention  . '" srcset="' . $wp_act . 'img/' . $midpath . '' . $filename . '.' . $extention  . ' 1x,' . $wp_act . 'img/' . $midpath . '' . $filename . '@2x.' . $extention  . ' 2x" alt="' . $alt . '" ' . $imagedata2[3] . ' loading="' . $load . '">' . LF;
            }
        } else {
            if ($load == 'none') {
                $html .= '<img src="' . $wp_act . 'img/' . $midpath . '' . $filename . '.' . $extention  . '" srcset="' . $wp_act . 'img/' . $midpath . '' . $filename . '.' . $extention  . ' 1x,' . $wp_act . 'img/' . $midpath . '' . $filename . '@2x.' . $extention  . ' 2x" alt="' . $alt . '" ' . $imagedata2[3] . '">' . LF;
            } else {
                $html .= '<img src="' . $wp_act . 'img/' . $midpath . '' . $filename . '.' . $extention  . '" srcset="' . $wp_act . 'img/' . $midpath . '' . $filename . '.' . $extention  . ' 1x,' . $wp_act . 'img/' . $midpath . '' . $filename . '@2x.' . $extention  . ' 2x" alt="' . $alt . '" ' . $imagedata2[3] . ' loading="' . $load . '">' . LF;
            }
        }
    } else {
        if ($webp != '') {
            $html .= '<source' . $webp_act3 . ' srcset="' . $wp_act . 'img/' . $webp_act . '' . $filename . '.' . $webp_act2 . '">' . LF;
            if ($load == 'none') {
                $html .= '<img src="' . $wp_act . 'img/' . $midpath . '' . $filename . '.' . $extention  . '" alt="' . $alt . '" ' . $imagedata2[3] . '">' . LF;
            } else {
                $html .= '<img src="' . $wp_act . 'img/' . $midpath . '' . $filename . '.' . $extention  . '" alt="' . $alt . '" ' . $imagedata2[3] . ' loading="' . $load . '">' . LF;
            }
        } else {
            if ($load == 'none') {
                $html .= '<img src="' . $wp_act . 'img/' . $midpath . '' . $filename . '.' . $extention  . '" alt="' . $alt . '" ' . $imagedata2[3] . '">' . LF;
            } else {
                $html .= '<img src="' . $wp_act . 'img/' . $midpath . '' . $filename . '.' . $extention  . '" alt="' . $alt . '" ' . $imagedata2[3] . ' loading="' . $load . '">' . LF;
            }
        }
    }
    $html .= '</picture>';
    $escape = h($html);

    file_put_contents($filename . '/picture.txt', $html);

    if ($img_rocal == '') {
        $escape = "画像を入れてください";
    }
}

function debug($val)
{/* デバック関数 */
    print '<pre>';
    print_r($val);
    print '</pre>';
}

function h($html)
{/* エスケープ（ブラウザに意味ないんだぜ） */
    return htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
}

?>

<style>
    textarea {
        display: block;
        width: 100%;
        height: 300px;
    }
</style>

<?php ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>picuture_tag_builder</title>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body>
    <form method="POST" action="">
        <input type="hidden" name="is_delete" value="1">
        <button class="reset" type="submit">リセット</button>
    </form>
    <form method="POST" enctype="multipart/form-data" action="">
        <!-- enctypeは画像があるときだけ -->
        <input type="hidden" name="is_post" value="1"><!-- ブラウザでは見えないが -->
        <textarea onfocus="this.select()"><?php print $escape; ?></textarea>
        <button class="built" type="submit">生成</button>
        <p>画像をドロップ</p>
        <input class="drop" type="file" name="img" value="<?php echo $_SESSION['img'] ?>">
        <p>alt</p>
        <input type="text" name="alt">
        <p>img以下中継フォルダ(語尾に/)</p>
        <input type="text" name="path" value="<?php echo $_SESSION['path'] ?>">
        <p>スマホブレイクポイント（数値のみ）</p>
        <input type="text" name="break_sp" value="<?php echo $_SESSION['break_sp'] ?>">
        <p>タブレットブレイクポイント（数値のみ）</p>
        <input type="text" name="break_tab" value="<?php echo $_SESSION['break_tab'] ?>">
        <div class="container">
            <div class="box">
                <p>各種設定</p>
                <div class="custom">
                    <label>
                        <input type="checkbox" name="wp" value="wp" <?php if ($_SESSION['wp'] == 'wp') {print 'checked="checked"';} ?>>wordpress
                    </label>
                    <label>
                        <input type="checkbox" name="webp" value="webp" <?php if ($_SESSION['webp'] == 'webp') {print 'checked="checked"';} ?>>webp
                    </label>
                    <label>
                        <input type="checkbox" name="retina" value="retina" <?php if ($_SESSION['retina'] == 'retina') {print 'checked="checked"';} ?>>Retina
                    </label>
                </div>
            </div>
            <div class="box">
                <p>loading</p>
                <div class="custom">
                    <label><input type="radio" name="loading" value="none">なし</label>
                    <label><input type="radio" name="loading" value="lazy" checked="checked">lazy</label>
                    <label><input type="radio" name="loading" value="eager">eager</label>
                    <label><input type="radio" name="loading" value="auto">auto</label>
                </div>
            </div>
        </div>
    </form>
    <div class="ex">
        <h2>※注意事項</h2>
        <p>
            作成ファイル名は以下のようにお願いします。<br>
            ファイル名@2x.拡張子 （レティナ用）<br>
            ファイル名_sp.拡張子 （スマホ用）<br>
            ファイル名_tab.拡張子 （タブレット用）<br>
            ファイル名_sp@2x.拡張子 （スマホ用レティナ）<br>
            ファイル名_tab@2x.拡張子 （タブレット用レティナ）<br>
        </p>
        <p>
            画像フォルダの最上階層はimgとしてください。<br>
            webpフォルダはimg/webpとし、それ以下にフォルダを作成しないでください。<br>
            フォルダ階層==============<br>
            img<br>
            　└中継フォルダ（任意）、webp<br>
            　　└画像、画像@2x、画像_sp、画像_tab、画像_sp@2x、画像_tab@2x
        </p>
    </div>

</body>

</html>