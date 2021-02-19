<section class="card w-100 ">
    <div class="container">
        <form action="#">
            <div class="row">
                <div class="col-9">
                    <div class="flex-column">
                        <h1>General informations</h1>
                        <label class="field">
                            <span>Movie name</span>
                            <input type="text">
                        </label>
                        <div class="flex">
                            <label class="field">
                                <span>Date</span>
                                <input type="date">
                            </label>
                            <label class="field">
                                <span>Start</span>
                                <input type="time">
                            </label>
                            <label class="field">
                                <span>End</span>
                                <input type="time">
                            </label>
                            <label class="field">
                                <span>Room</span>
                                <input type="text">
                            </label>
                        </div>
                        <a href="#" class="link m-s">Add a session</a>
                    </div>
                    <div>
                        <h1>Metadata</h1>
                        <div class="flex">
                            <label class="field">
                                <span>Directed by</span>
                                <input type="text">
                            </label>
                            <button class="button">Add</button>
                        </div>
                        <div class="flex">
                            <label class="field">
                                <span>Staring</span>
                                <input type="text">
                            </label>
                            <button class="button">Add</button>
                        </div>
                        <div>
                            <label class="field field-area">
                                <span>Synopsis</span>
                                <textarea rows="8"></textarea>
                            </label>
                        </div>
                        <div class="flex">
                            <label class="field">
                                <span>Tags</span>
                                <input type="text">
                            </label>
                            <button class="button">Add</button>
                        </div>
                    </div>
                </div>
                <div class="col-3 flex-column flex-bottom">
                    <div class="flex-column flex-top">
                        <h1>Movie Cover</h1>
                        <!-- <img src="icons/image-placeholder.svg" alt="placeholder"> -->
                        <div class="image-input-portrait">
                            <button>+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container flex flex-center">
                <button class="button button--success">Confirm</button>
                <button class="button button--danger">Cancel</button>
            </div>
        </form>
    </div>
</section>