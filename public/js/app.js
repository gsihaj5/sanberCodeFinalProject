function postPertanyaan(token) {
    var judul = $("#inputJudul").val();
    var isi = CKEDITOR.instances.isiPertanyaan.getData()

    jQuery.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:'/pertanyaan/create',
        data:{
            "_token":token,
            judul:judul,
            isi:isi
        },
        success:function(data) {
            var alertmessage = $("#alertMessage")
            alertmessage.addClass("alert-success")
            alertmessage.html(data.msg)
            alert("peratanyaan berhasil di buat")
            window.location.replace("/home");
        }
    });
 }

function upVote(token, id, type){
    var route

    if(type === "pertanyaan"){
        route = '/pertanyaan/upVote/'+id
    }
    else if(type === "jawaban"){
        route = '/jawaban/upVote/'+id
    }
    console.log(type)
    console.log(route)

    jQuery.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: route,
        data:{
            "_token":token
        },
        success:function(data) {
            var vote
            if(type === "pertanyaan"){
                vote = $("#vote_"+id)
            }else
                vote = $("#vote_jawaban_"+id)
            console.log(vote)
            vote.html(data.result)
        },
        error: function(data){
            console.log(data)
            alert(data.responseJSON.msg);
        }
    });
}

function downVote(token, id, type){
    var route

    if(type === "pertanyaan"){
        route = '/pertanyaan/downVote/'+id
    }
    else if(type === "jawaban"){
        route = '/jawaban/downVote/'+id
    }
    console.log(type)
    console.log(route)

    jQuery.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:route,
        data:{
            "_token":token
        },
        success:function(data) {
            var vote
            if(type === "pertanyaan"){
                vote = $("#vote_"+id)
            }else
                vote = $("#vote_jawaban_"+id)
            console.log(vote);
            vote.html(data.result)
        },
        error: function(data){
            console.log(data);
            alert(data.responseJSON.msg);
        }
    });
}

function postJawaban(token, pertanyaan_id){
    var isi = CKEDITOR.instances.jawaban.getData()

    jQuery.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:'/jawaban/create/'+pertanyaan_id,
        data:{
            "_token":token,
            isi:isi
        },
        success:function(data) {
            console.log(data)
        }
    });
 }
