<x-main-layout pageTitle="Game">
    <div class="container">

        <x-question :country="$country" :currentQuestion="$current_question" :totalQuestions="$total_questions" />


        <div class="row">

            @foreach ($alternatives as $alternative)
                <x-alternative :capital="$alternative" />
            @endforeach

        </div>

    </div>

    <!-- cancel game -->
    <div class="text-center mt-5">
        <a href="#" class="btn btn-outline-danger mt-3 px-5">CANCELAR JOGO</a>
    </div>

</x-main-layout>
