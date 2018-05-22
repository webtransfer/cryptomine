<style>
          .colelem {position: relative; display: none;}
                .expelem {position: relative; display: block;}
                .exeexe {position: relative; cursor:pointer; color:red;}
                #head1 {width:300; background:gold;}

                </style>
                <script type="text/javascript">
                
                var zakr='';    //
                var zzakk='';   //
              
                function Tree(Event) {
                        if (window.event) zzakk=event.srcElement;
                        else zzakk=Event.target;
                        zakr=zzakk.className;  //
                        if (zakr=="exelem") Rackr(1,(zzakk.childNodes.length-1));      //
                        else if (zakr=="exeexe") Rackr(0,(zzakk.childNodes.length-1)); //
                }

               
                function Rackr(pos,kol) {
                        if (kol>0) {
                                if (zzakk.childNodes[kol].className=="colelem") {
                                        if (zzakk.childNodes[kol].childNodes.length!=1) zzakk.childNodes[kol].style.color="red";
                                        else zzakk.childNodes[kol].style.color="black";
                                        zzakk.childNodes[kol].className="exelem";    //
                                        zzakk.childNodes[kol].style.position="absolute";  //
                                //
                                        if (pos==0) 
                                                zzakk.childNodes[kol].style.left=parseInt(document.getElementById("head1").style.left)+5;        
                                        else if (pos!=0)
                                                        zzakk.childNodes[kol].style.left=parseInt(zzakk.style.left)+5;
                                        zzakk.childNodes[kol].style.position="relative";  //
                                }
                                else 
                                        if (zzakk.childNodes[kol].className) {
                                                zzakk.childNodes[kol].style.color="black";
                                                zzakk.childNodes[kol].className="colelem";
                                        }
                                setTimeout("Rackr("+pos+","+(kol-1)+")",50);
                                        //
                                }                                
                }
               
                </script>
        </head>
        <body onClick="Tree(event)"> 
                <div id="head1" style="position:relative;left:5;">
                
                        <div class="exeexe" id="a1">1
                                <div class="colelem" id="a2">1.1
                                        <div class="colelem" id="a3">1.1.1</div>
                                        <div class="colelem" id="a4">1.1.2
                                                <div class="colelem" id="a5">1.1.2.1</div>
                                                <div class="colelem" id="a6">1.1.2.2</div>
                                        </div>
                                        <div class="colelem" id="a7">1.1.3</div>
                                </div>
                                <div class="colelem" id="a8">1.2</div>
                                <div class="colelem" id="a9">1.3</div>
                                <div class="colelem" id="a10">1.4
                                        <div class="colelem" id="a11">1.4.1</div>
                                        <div class="colelem" id="a12">1.4.2</div>
                                </div>
                        </div>

                        <div class="exeexe" id="a13">2
                                <div class="colelem" id="a14">2.1
                                        <div class="colelem" id="a15">2.1.1</div>
                                        <div class="colelem" id="a16">2.1.2</div>
                                </div>
                        </div>

                        <div class="exeexe" id="a13">3
                                <div class="colelem" id="a14">3.1
                                        <div class="colelem" id="a15">3.1.1
                                                <div class="colelem" id="a16"><a href="1.htm">3.1.1.1</a></div>
                                        </div>
                                </div>
                                <div class="colelem" id="a14"><a href="2.htm">3.2</a>
                                </div>
                        </div>
                        
                </div>
        </body>
</html>