//画像枚数
var scoob_max = 4;

//画像を格納する配列
var scoob_bnr = new Array();

//読み込むバナーの数だけ書く
scoob_bnr[0] = new Image();
scoob_bnr[0].src = "http://scoob.info/scoob/wp-content/themes/scoob01/images/lg_2015_01.png";
scoob_bnr[1] = new Image();
scoob_bnr[1].src = "http://scoob.info/scoob/wp-content/themes/scoob01/images/lg_2015_02.png";
scoob_bnr[2] = new Image();
scoob_bnr[2].src=  "http://scoob.info/scoob/wp-content/themes/scoob01/images/lg_2015_03.png";
scoob_bnr[3] = new Image();
scoob_bnr[3].src=  "http://scoob.info/scoob/wp-content/themes/scoob01/images/lg_2015_04.png";


//画像番号
var scoob_cnt=0;

//画像切り替え関数
function changeBnr(){
  
  //画像番号を進める
  if (scoob_cnt == scoob_max-1)
  { scoob_cnt=0; }
  else
  { scoob_cnt++; }
  
  //#scoob_bnrのsrcを書き換える
  document.getElementById("scoob_bnr").src=scoob_bnr[scoob_cnt].src;
}

//メソッド呼び出し(初期値は5000ミリ秒
setInterval("changeBnr()",10000);