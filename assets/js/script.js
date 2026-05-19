$(function(){
  $('.confirm-delete').on('click', function(e){
    if(!confirm('Yakin ingin menghapus data ini?')) e.preventDefault();
  });

  const $steps = $('.question-step');
  const total = $steps.length;
  let currentStep = 0;

  function showQuestion(index){
    if (!total) return;
    currentStep = Math.max(0, Math.min(index, total - 1));
    $steps.removeClass('active').eq(currentStep).addClass('active');
    $('#prevQuestion').prop('disabled', currentStep === 0);
    $('#submitConsult').toggleClass('d-none', currentStep !== total - 1);
    updateProgress();
  }

  function updateProgress(){
    const answered = $('.answer-radio:checked').length;
    const pct = total ? Math.round((answered / total) * 100) : 0;
    $('#consultProgress').css('width', pct+'%').text(pct+'%');
  }

  $('.answer-radio').on('change', function(){
    updateProgress();
    if (currentStep < total - 1) {
      window.setTimeout(function(){
        showQuestion(currentStep + 1);
      }, 180);
    }
  });

  $('#prevQuestion').on('click', function(){
    showQuestion(currentStep - 1);
  });

  showQuestion(0);
});
