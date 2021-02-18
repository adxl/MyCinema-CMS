<section class="card w-100 ">
    <div>
        <form action="#">
            <div class="flex-column">
                <h1>General informations</h1>
                <label class="field">
                    <span>Movie name</span>
                    <input type="text">
                </label>
                <div class="flex">
                    <div class="flex">
                        <label class="field">
                            <span>Date</span>
                            <input type="text" size="4" onInput="this.parentNode.dataset.value = this.value">
                        </label>
                        <button class="button">
                            <img src=" " alt=" ">
                        </button>
                    </div>
                    <label class="field">
                        <span>Start</span>
                        <input type="number" size="4" onInput="this.parentNode.dataset.value = this.value">
                    </label>
                    <label class="field">
                        <span>End</span>
                        <input type="number" size="4" onInput="this.parentNode.dataset.value = this.value">
                    </label>
                    <label class="field">
                        <span>Room</span>
                        <input type="text" size="4" onInput="this.parentNode.dataset.value = this.value">
                    </label>
                </div>
                <a href="#" class="link m-s">Add a session</a>
            </div>
            <div>
                <h1>Metadata</h1>
                <div class="flex">
                    <label class="field">
                        <span>Directed by</span>
                        <input type="text" size="4" onInput="this.parentNode.dataset.value = this.value">
                    </label>
                    <button class="button">Add</button>
                </div>
                <div class="flex">
                    <label class="field">
                        <span>Staring</span>
                        <input type="text" size="4" onInput="this.parentNode.dataset.value = this.value">
                    </label>
                    <button class="button">Add</button>
                </div>

                <div>
                    <label class="field">
                        <span>Synopsis</span>
                        <input type="text" size="4" onInput="this.parentNode.dataset.value = this.value">
                    </label>
                </div>


                <div class="flex">
                    <label class="field">
                        <span>Tags</span>
                        <input type="text" size="4" onInput="this.parentNode.dataset.value = this.value">
                    </label>
                    <button class="button">Add</button>
                </div>
            </div>
            <div class="flex flex-center">
                <button class="button button--success">Confirm</button>
                <button class="button button--danger">Cancel</button>
            </div>
        </form>
    </div>
</section>