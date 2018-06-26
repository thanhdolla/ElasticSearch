<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Elasticsearch</title>

    <link rel="stylesheet" href="./https:_maxcdn.bootstrapcdn.com_bootstrap_4.0.0-alpha.4_css_bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <script src="./https:_ajax.googleapis.com_ajax_libs_jquery_3.0.0_jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script src="./https:_cdnjs.cloudflare.com_ajax_libs_tether_1.2.0_js_tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="./https:_maxcdn.bootstrapcdn.com_bootstrap_4.0.0-alpha.4_js_bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
    <script src="../jquery.twbsPagination.js" type="text/javascript"></script>
    <script src="./https:_code.jquery.com_ui_1.12.1_jquery-ui.js"></script>
    <link rel="stylesheet" href="./http:_code.jquery.com_ui_1.12.1_themes_base_jquery-ui.css">
</head>
<style>
    [view = st]{
        
    }
    [view = image]{
   
    }
    .rc {
        margin-bottom:20px;
        position: relative;
        width: 100%;
        height: 9em;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .sl, .r {
        display: inline;
        font-weight: normal;
        margin: 0;
    }

    .rc h3 {
        font-size: 18px;
        font-family: arial, sans-serif;
    }

    .s span {
        color: #545454;
        font-size: small;
        font-family: arial, sans-serif;
        text-align: left;
        font-weight: normal;
        line-height: 1.4;
        word-wrap: break-word;
    }

    #slim_appbar {
        font-family: arial, sans-serif;
    }

    #resultStats {
        line-height: 43px;
        color: #808080;
    }

    .iUh30 {
        line-height: 16px;
        color: #006621;
        font-style: normal;
        font-size: 14px;
    }
.len{
    animation : cdlen 1s ease forwards;
}
@-webkit-keyframes cdlen{
   from{transform:translateY(200px);opacity:0;};
   to{transform:translateX(0px);opacity:1;};
}
</style>
<body>

<div class="container-fluid">
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div id='ajax_loader' style="margin: auto;text-align: center;margin-top: 277px;">
        <img src="./loading.gif" style="max-width: 200px;"></img>
        </div>
      
    </div>
  </div>
<div class="row" style="background-color: #FAFAFA;height: 100px">
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="line-height: 100px">
            <img view="image" src="./download.png" style="max-width: 220px;margin-left:100px;" class="img-responsive" alt="Image">
        </div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="line-height: 100px">

            <form method="post" action="" class="form-inline" style="margin-left:150px;display: inline-flex">
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <div class="form-group">
                <!-- <div class="ui-widget"> -->
  <!-- <label for="key">Tags: </label> -->
 
                    <div class="ui-widget" >
                    <input id="key" name="key" class="form-control" style="width: 550px" type="text" class="form-control"
                           placeholder="Search for...">
                           <input type="button" id="btn"  class="btn btn-default" value="Search" />
                           </div>
                           <!-- </div> -->
                    
                </div>
            </form>
        </div>
    </div>
    
        <div class="row">
           <div class="container">
                <div class="ab_tnav_wrp" id="slim_appbar">
                    <div id="sbfrm_l">
                        
                        </div>
                    </div>
            </div>
            
            <div class="container" id="resultSearch">
                
            </div>
        </div>
    </div>
</div>
<div class="container">
    <nav aria-label="Page navigation">
        <ul class="pagination" id="pagination"></ul>
    </nav>
</div>


<script >
$(document).ready(function(){
    let data=""
    $( "#key" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: "http://192.168.0.127/pagination/examples/getData1.php",
            method: 'POST',
            dataType: "json",
            data: {
                    key:$("#key").val()
            },
            success: function( data ) {

    
                console.log(data.hits.hits);
                response(data.hits.hits.map(item=>item._source.title));
            }
          });
        },
        minLength: 3,
        open: function(){
                $('.ui-autocomplete').css('width', '550px'); // HERE
        }
      });
    let createComponent=(title,link,content)=>{
        let component=`<div class="rc">`
        component=component+`<h3 class="r">`
        component=component+`<a href="${link}" data-href="https://vnexpress.net/">${title}</a></h3>`
        component=component+`<div class="s">
        <div>
            <div class="f hJND5c TbwUpd" style="white-space:nowrap">`
        component=component+`<cite class="iUh30">${link}</cite></div>`
        component=component+`<span class="st" s>${content}</span>`
        component=component+`</div>`
        component=component+`</div>`
        component=component+`</div>`
        return component
    }
    let getData=()=>{
        return new Promise((resolve,reject)=>{
            $.ajax({
                url: 'http://192.168.0.127/pagination/examples/getData.php',
                method: 'POST',
                data: {
                    key:$("#key").val()
                },
                dataType: 'json',
                beforeSend: function(){
                    $("#myModal").modal('show')
                },
                success: function(msg){
                    var total=`<div id="resultStats">Khoảng kết quả ${msg.hits.total}</div>`
                    $("#sbfrm_l").html(total)
                    resolve(msg.hits.hits)
                    $("#myModal").modal('hide')
                    // var array = msg.hits.hits._source.title
                    // console.log(total)
                },
                error: function(err){
                    console.log(err)
                }
            });
        })
    }



    $("#btn").click(()=>{
        // console.log('jhjj')
        
        getData().then((msg)=>{
            console.log(msg);
            data=msg
            index1=1
            index2=12
            console.log('tim kiem xong');
            $("#resultSearch").empty()
            $('#pagination').twbsPagination('destroy');

            $('#pagination').twbsPagination({
                currentPage: 1,
                totalPages: msg.length/30,
                visiblePages: 10,
                onPageClick: function (event, page) {
                    // console.info(data.slice((page-1)*41,(page*41-1)));
                    let content=data.slice((page-1)*31,(page*31-1))
                    $("#resultSearch").empty()
                    
                    content.map((value)=>{
                        // console.log(value._source.title,value._source.url,value._source.content);
                        let tempComponent=createComponent(value._source.title,value._source.url,value._source.content)
                        $("#resultSearch").append(tempComponent)
                    })
                
                }
            });
            
        })
    }
    
)

})


</script>

</body>
</html>