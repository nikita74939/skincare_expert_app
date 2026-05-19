$(function(){
  $('.confirm-delete').on('click', function(e){
    if(!confirm('Yakin ingin menghapus data ini?')) e.preventDefault();
  });
  const total = $('.question-item').length;
  function updateProgress(){
    const answered = $('.answer-radio:checked').length;
    const pct = total ? Math.round((answered/total)*100) : 0;
    $('#consultProgress').css('width', pct+'%').text(pct+'%');
  }
  $('.answer-radio').on('change', updateProgress);
  updateProgress();
});
