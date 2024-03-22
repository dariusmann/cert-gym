<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';

export default {
    name: "ReadinessScore",
    components: {AuthenticatedLayout, TabView, TabPanel}
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="h-5"></div>
        <TabView class="shadow-2xl border-roun">
            <TabPanel header="Readiness Score">
                <div class="prose">
                    <h1>Understanding Your Readiness Score</h1>
                    <p>In our learning platform, we are dedicated to providing you with comprehensive tools to track
                        your progress
                        and readiness for your RBT (Registered Behaviour Technician) exams. A pivotal element of this
                        tracking is
                        your "Readiness Score." This guide is designed to help you understand how your Readiness Score
                        is
                        calculated, what it represents, and how you can use this information to enhance your learning
                        experience.</p>

                    <h2>What is the Readiness Score?</h2>
                    <p>The Readiness Score is a numerical representation of your current level of preparedness for the
                        RBT
                        examination. It is derived from your performance across various task list categories covered in
                        the practice
                        exams. This score is calculated by analysing your accuracy rates in these categories, providing
                        a clear and
                        concise metric of your readiness.</p>

                    <h2>How is the Readiness Score Calculated?</h2>
                    <ol>
                        <li><strong>Examination Structure</strong>: Our practice exams are structured to cover all the
                            task list
                            categories necessary for the RBT exam. Each exam consists of a specified number of questions
                            (X) from
                            every task list category.
                        </li>
                        <li><strong>Selection of Questions</strong>: To calculate your Readiness Score, we take the last
                            X questions
                            you've answered in each task list category and then select an additional 2 questions from
                            those
                            attempts. This selection aims to analyse your most recent performance, ensuring the score
                            reflects your
                            current understanding and readiness.
                        </li>
                        <li><strong>Accuracy Rate Calculation</strong>: For each task list category, we calculate your
                            accuracy rate
                            based on the selected questions. This is done by dividing the number of questions you
                            answered correctly
                            by the total number of questions considered (X + 2), resulting in a percentage that reflects
                            your
                            proficiency in that specific category.
                        </li>
                        <li><strong>Average Accuracy Rate</strong>: Once we have calculated the accuracy rates for all
                            task list
                            categories, we compute the average of these rates. This average accuracy rate forms your
                            Readiness
                            Score.
                        </li>
                    </ol>

                    <h2>Interpreting Your Readiness Score</h2>
                    <p>Your Readiness Score is a dynamic measure of your current ability to successfully pass the RBT
                        examination,
                        with a higher score indicating greater readiness. It is crucial to understand that this score is
                        not static;
                        it will fluctuate as you continue to engage with practice questions and refine your
                        understanding of the
                        task list categories. A Readiness Score of 80% or higher is considered indicative of being
                        well-prepared for
                        the RBT examination.</p>

                    <h2>Conclusion</h2>
                    <p>Your Readiness Score is a valuable tool in your journey towards RBT certification, offering a
                        clear
                        indication of your strengths and areas for improvement. By understanding how this score is
                        calculated and
                        what it signifies, you can tailor your study approach to enhance your readiness for the RBT exam
                        effectively. Continue to engage with the practice exams and utilise your score as a guide to
                        ensure your
                        preparation is focused and efficient.</p>
                </div>
            </TabPanel>
            <TabPanel header="Accuracy Rate">
                <div class="prose">

                    <h1>Understanding Your Accuracy Rate Score</h1>
                    <p>In our commitment to offering comprehensive tools for tracking your progress on our RBT
                        (Registered Behaviour
                        Technician) learning platform, we introduce the "Accuracy Rate Score." This component of your
                        tracking
                        dashboard offers insight into your performance over the most recent set of practice questions.
                        Below is a
                        detailed explanation of what the Accuracy Rate Score is, how it is calculated, and its
                        significance.</p>

                    <h2>What is the Accuracy Rate Score?</h2>
                    <p>The Accuracy Rate Score represents the percentage of questions you have answered correctly out of
                        the last
                        100 questions you have attempted. This score provides a snapshot of your current performance,
                        focusing
                        specifically on your recent interactions with our practice exams. It's a dynamic measure that
                        updates as you
                        answer more questions, reflecting your latest learning achievements and areas needing
                        attention.</p>

                    <h2>How is the Accuracy Rate Score Calculated?</h2>
                    <ol>
                        <li><strong>Selection of Questions</strong>: The score is based on your most recent 100
                            questions across all
                            task list categories. This approach ensures that the score reflects your current knowledge
                            and
                            understanding.
                        </li>
                        <li><strong>Calculating Correct Answers</strong>: We count the number of questions you answered
                            correctly
                            within this set of 100 questions.
                        </li>
                        <li><strong>Determining the Score</strong>: The Accuracy Rate Score is then calculated by
                            dividing the
                            number of correct answers by 100, the total number of questions considered. This result is
                            presented as
                            a percentage.
                        </li>
                    </ol>

                    <h2>The Significance of Your Accuracy Rate Score</h2>
                    <p>The Accuracy Rate Score serves as an immediate reflection of your learning progress. Here's how
                        to interpret
                        and use this score:</p>
                    <ul>
                        <li><strong>A Measure of Current Performance</strong>: It shows how well you are grasping the
                            material right
                            now, allowing you to see improvements or identify areas that may require more focus.
                        </li>
                        <li><strong>Feedback for Focused Study</strong>: By reflecting your recent performance, the
                            score can help
                            you tailor your study strategy. Areas where your accuracy is lower might benefit from
                            additional review
                            or practice.
                        </li>
                        <li><strong>Dynamic Learning Indicator</strong>: As you continue to answer more questions, your
                            Accuracy
                            Rate Score will update, providing you with ongoing feedback about your learning journey.
                        </li>
                    </ul>

                    <h2>Conclusion</h2>
                    <p>The Accuracy Rate Score on your tracking dashboard is an essential tool in your RBT exam
                        preparation. It
                        offers immediate, actionable feedback on your recent performance, helping you identify strengths
                        and areas
                        for improvement. As you engage with our learning materials and practice exams, keep an eye on
                        this score to
                        guide your study efforts effectively, ensuring you are always moving forward in your
                        preparation.</p>
                </div>
            </TabPanel>
        </TabView>

    </AuthenticatedLayout>
</template>

<style lang="scss" scoped>


</style>
