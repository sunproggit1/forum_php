//////////////////mini-game section//////////////
document.getElementById('startbtn').innerHTML = "Start";
document.getElementById('stopbtn').innerHTML = "Stop";
var startall = document.getElementById('startbtn');
var stopall = document.getElementById('stopbtn');


		var timeleft=20000;
		var counter1=20;
		var level=1;
		var count=0, finishcount=0; var s; s='s';
		var rand = Math.floor(Math.random()*80);var rand2;
		var enablescore=20;
		var counttimer;
		var scoretimer;
		var marktimer;
		var timer;
		var surprisetimer;
		var label=20;
		var markplace = document.getElementsByClassName('area')[rand];

				function mark2() {
					document.getElementsByClassName('area')[rand].src = "../images/space.jpg";
					 rand2 = Math.floor(Math.random()*80);
					document.getElementsByClassName('area')[rand2].src = "../images/mark.jpg";
					count++;
					rand=rand2;
					markplace.removeEventListener('mouseover', mark2);
					markplace = document.getElementsByClassName('area')[rand2];
					markplace.addEventListener('mouseover', mark2);
				}
				
				function counter(){
						 
						if(counter1>0){counter1--;
							document.getElementsByClassName('timer')[0].innerHTML = "Level " + level + "(" + enablescore + ")" + ": Time: " + counter1;}
						
					}
				
				function score() {
					jQuery('.highscore').html(count);
					markplace.addEventListener('mouseover', mark2);
					
				}
				function mark() {
						document.getElementsByClassName('area')[rand].src="../images/mark.jpg";
								}
				
				function mark1() {clearInterval(timer);
					if(count>=enablescore) 
						{
							
							level++;label++;
							enablescore+=3;timeleft+=1000;
							document.getElementsByClassName('timer')[0].innerHTML = count + ": " + "You win! Next level!";
							for(var i=0;i<80;i++){document.getElementsByClassName('area')[i].src="../images/space.jpg";}
						timer = setInterval('mark1()', timeleft);
						}
					else 
					{
						 document.getElementsByClassName('timer')[0].innerHTML = count + ": " + "You lose! Current level!";
						for(var i=0;i<80;i++){document.getElementsByClassName('area')[i].src="../images/space.jpg";}
						markplace.removeEventListener('mouseover', mark2);
	clearInterval(counttimer);
	clearInterval(scoretimer);
	clearInterval(marktimer);
	clearInterval(timer);
	clearInterval(surprisetimer);
	counter1=0;count=0;level=1;enablescore=20;timeleft=20000;label=20;
	
	$('#startbtn').removeClass("glyphicon glyphicon-play");
	$('#startbtn').addClass("glyphicon glyphicon-repeat");
	$('#startbtn').text("Restart");
					}
					count=0;counter1=label;
				}

function start(){
	for(var i=0;i<80;i++){document.getElementsByClassName('area')[i].src="../images/space.jpg";}
	markplace.removeEventListener('mouseover', mark2);
	clearInterval(counttimer);
	clearInterval(scoretimer);
	clearInterval(marktimer);
	clearInterval(timer);
	clearInterval(surprisetimer);
	counter1=0;count=0;level=1;enablescore=20;timeleft=20000;label=20;
	document.getElementsByClassName('timer')[0].innerHTML = "Level " + level + "(" + enablescore + ")" + ": Time: " + counter1;
	document.getElementsByClassName('area')[rand].src = "../images/marked.jpg";
	markplace.addEventListener('mouseover', mark2);
	counttimer = setInterval('counter()', 1000);
	scoretimer = setInterval('score()', 100);
	marktimer = setInterval('mark()', 1000);
	timer = setInterval('mark1()', 20000);
	surprisetimer = setInterval('kinder_surprise()', 1500);
	counter1=label;

}
function stop(){
	for(var i=0;i<80;i++){document.getElementsByClassName('area')[i].src="../images/space.jpg";}
	markplace.removeEventListener('mouseover', mark2);
	clearInterval(counttimer);
	clearInterval(scoretimer);
	clearInterval(marktimer);
	clearInterval(timer);
	clearInterval(surprisetimer);
	counter1=0;count=0;level=1;enablescore=20;timeleft=20000;label=20;
	document.getElementsByClassName('timer')[0].innerHTML = "Level " + level + "(" + enablescore + ")" + ": Time: " + counter1;
	$('#startbtn').removeClass("glyphicon glyphicon-repeat");
	$('#startbtn').addClass("glyphicon glyphicon-play");
	$('#startbtn').text("Start");

}

startall.addEventListener('click', start);
stopall.addEventListener('click', stop);
///////////////////////////////////////////////

