<template>
    <div class="row">
        <div class="col-11">
            <div class="card">
                <div class="card-header text-align: center" style="font-weight: bold">
                    <span style="display: inline-block; width: 45.5%;">Category: {{data.category.name}}</span>

                    <span>
                          Difficulty: {{difficulty}}
                    </span>
                    <span style="display: inline-block; float: right;">
                    Possible Points: {{questionPoints}}
                    </span>
                </div>
            </div>
            <div class="card" style="font-weight: bold">
                <div class="card-header">
                    Question {{count}}: {{question}}
                </div>
                <div class="card-body">
                    <ul style="list-style: none">
                        <li v-for="answer in answers">
                            <input type="radio" :value="answer" v-model="selectedAnswer" name="answer">
                            {{answer.answer}}
                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary btn-block" style="font-weight: bolder" @click="submit">
                        Submit answer
                    </button>
                </div>
            </div>
        </div>
        <div class="col-1">
            {{countdown}}
        </div>
    </div>
</template>
<script>

    import axios from 'axios'
    import Event from '../event'

    export default {
        props: {
            user: {
                type: Object,
                required: true,
            }
        },
        data() {
            return {
                selectedAnswer: null,
                question: null,
                data: {
                    category: {
                        name: null,
                    },
                    difficulty: {
                        name: null,
                    },
                },
                difficulty: '',
                answers: null,
                count: 1,
                questionPoints: 0,
                totalPoints: 0,
                countdown: 10,
            }
        },
        methods: {
            countDownTimer() {
                if (this.countdown > 0) {
                    setTimeout(() => {
                        this.countdown -= 1
                        this.countDownTimer()
                    }, 1000)
                }
                if (this.countdown === 0) {
                    alert("You have failed to answer this question")
                    this.failedToAnswer()
                }
            },
            failedToAnswer() {
                axios.post('/api/question', {
                    question_id: this.data.id,
                    is_correct: false,
                    answer_id: 0,
                    points: parseInt('-' + this.questionPoints),
                    user_id: this.user.id,
                    count: this.count
                }).then(() => {
                    this.countdown = 60;
                    // this.countDownTimer()
                })

                if (this.count === 10) {
                    alert('You finished the quiz')
                    return window.location.href ='/dashboard';
                }
                this.fetchQuestion()
            },
            fetchQuestion() {
                console.log('fetchQuestion()...');
                axios.get('/api/question?user_id=' + this.user.id)
            },
            submit() {
                if (!this.selectedAnswer) {
                    alert('Chose an answer')
                    return;
                }
                axios.post('/api/question', {
                    question_id: this.data.id,
                    answer_id: this.selectedAnswer.id,
                    is_correct: this.selectedAnswer.is_correct,
                    points: this.selectedAnswer.is_correct ? this.questionPoints : parseInt('-' + this.questionPoints),
                    user_id: this.user.id,
                    count: this.count
                }).then(() => {
                    this.countdown = 10;
                })
                this.count++;
                if (this.count === 10) {
                    alert('You successfully finished the quiz')
                    return window.location.href ='/dashboard';
                }
            }
        },
        mounted() {
            Echo.channel('quiz.' + this.user.id)
                .listen('.newQuestion', (e) => {
                    console.log('fired');
                    console.log(e);
                    Event.$emit('question_fetched', e);
                });

            this.fetchQuestion();

            Event.$on('question_fetched', (e) => {
                this.data = e.data;
                this.question = e.data.question;
                this.answers = e.data.answers;
                // this.count++;

                this.difficulty =
                    this.data.difficulty.name.charAt(0).toUpperCase() +
                    this.data.difficulty.name.substring(1)

                if (this.data.difficulty.name === 'easy') {
                    this.questionPoints = 1;
                }
                if (this.data.difficulty.name === 'medium') {
                    this.questionPoints = 2;
                }
                if (this.data.difficulty.name === 'hard') {
                    this.questionPoints = 3;
                }
            })

            // this.countDownTimer()
        }
    }

</script>
