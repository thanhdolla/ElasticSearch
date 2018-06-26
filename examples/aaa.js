$(document).ready(function(){
    let data=""
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


    $("#btn").click(()=>{
        console.log('jhjj')
        $("#resultSearch").empty()
        getData().then((msg)=>{
            console.log(msg.length);
            data=msg
            index1=1
            index2=12
            var obj = $('#pagination').twbsPagination({
                totalPages: msg.length/50,
                visiblePages: 10,
                onPageClick: function (event, page) {
                    console.info(data.slice((page-1)*41,(page*41-1)));
                    let content=data.slice((page-1)*41,(page*41-1))
                    $("#resultSearch").empty()
                    content.map((value)=>{
                        console.log(value._source.title,value._source.url,value._source.content);
                        let tempComponent=createComponent(value._source.title,value._source.url,value._source.content)
                        $("#resultSearch").append(tempComponent)
                    })
                
                }
            });
            
        })
    }
    
)

})

