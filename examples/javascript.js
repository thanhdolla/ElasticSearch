import { WSAEINVALIDPROVIDER } from "constants";

$(document).ready(function(){
    let data=""
    $( "#key" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: "http://localhost/pagination/examples/getData.php",
            dataType: "json",
            data: {},
            success: function( data ) {
                let content=data.hits.hits.slice((2-1)*10,(2*10-1))
                response(content.map(item=>item._source.title));
            }
          });
        },
        minLength: 3
      });
    let createComponent=(title,link)=>{
        let component=`<div class="rc">`
        component=component+`<h3 class="r">`
        component=component+`<a href="${link}" data-href="https://vnexpress.net/">${title}</a></h3>`
        component=component+`<div class="s">
        <div>
            <div class="f hJND5c TbwUpd" style="white-space:nowrap">`
        component=component+`<cite class="iUh30">https://vnexpress.net/</cite></div>`
        component=component+`<span class="st">Thông tin nhanh &amp; mới nhất được cập nhật hàng giờ. Tin tức Việt Nam &amp; thế giới về xã hội, kinh doanh, pháp luật, khoa học, công nghệ, sức khoẻ, đời sống, văn hóa, rao vặt, tâm sự...</span>`
        component=component+`</div>`
        component=component+`</div>`
        component=component+`</div>`
        return component
    }
    let getData=()=>{
        return new Promise((resolve,reject)=>{
            $.ajax({
                url: 'http://localhost/pagination/examples/getData.php',
                method: 'POST',
                data: {
                    key:$("#key").val()
                },
                dataType: 'json',
                beforeSend: function(){
                    
                },
                success: function(msg){
                    var total=`<div id="resultStats">Khoảng kết quả ${msg.hits.total}</div>`
                    $("#sbfrm_l").html(total)
                    resolve(msg.hits.hits)
                },
                error: function(err){
                    console.log(err)
                }
            });
        })
    }
    // 1=>0 9
    // 2=>10 19
    // 3=>20 29
    // 4=>30 39
    // 5=>40 49
    sao lai cai nay ham onlick dau roi
    getData().then((msg)=>{
        console.log(msg.length);
        data=msg
        index1=1
        index2=10
        var obj = $('#pagination').twbsPagination({
            totalPages: msg.length/50,
            visiblePages: 5,
            onPageClick: function (event, page) {
                console.info(data.slice((page-1)*10,(page*10-1)));
                let content=data.slice((page-1)*10,(page*10-1))
                $("#resultSearch").empty()
                content.map((value)=>{
                    console.log(value._source.title,value._source.url);
                    
                    let tempComponent=createComponent(value._source.title,value._source.url)
                    $("#resultSearch").append(tempComponent)
                })
                // content.forEach(element => {
                //     $("#resultSearch").empty()
                //     $("#resultSearch").append(component)
                // });
            }
        });
    })
})