    <div class="flex my-s mt-0">
        <i class="fas fa-calendar-alt"></i>
        <h1 class="mx-s"><?= $title; ?>
        </h1>
    </div>
    <section class="card w-100 ">
        <div class="container">
            <?php App\Core\FormBuilder::render($form); ?>
        </div>
    </section>

    <!-- INTÉGRATION STATIQUE : NE PAS UTILISER -->
    <?php if (false) : ?>
        <form action="#" method="POST">
            <div class="row">
                <div class="col-9">
                    <div class="flex-column">
                        <h1>General informations</h1>
                        <label class="field">
                            <span>Movie name</span>
                            <input type="text" required>
                        </label>
                        <!-- session -->
                        <div class="flex">
                            <label class="field">
                                <span>Date</span>
                                <input type="date" required>
                            </label>
                            <label class="field">
                                <span>Start</span>
                                <input type="time" required>
                            </label>
                            <label class="field">
                                <span>End</span>
                                <input type="time" required>
                            </label>
                            <label class="field">
                                <span>Room</span>
                                <select name="room" required>
                                    <option value=""></option>
                                    <option value="A1">A1</option>
                                    <option value="A2">A2</option>
                                    <option value="B1">B1</option>
                                    <option value="B3">B3</option>
                                    <option value="C2">C2</option>
                                </select>
                            </label>
                        </div>
                        <!-- session -->
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
                                <select name="room">
                                    <option value=""></option>
                                    <option value="A1">A1</option>
                                    <option value="A2">A2</option>
                                    <option value="B1">B1</option>
                                    <option value="B3">B3</option>
                                    <option value="C2">C2</option>
                                </select>
                            </label>
                        </div>
                        <!-- session -->
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
                                <select name="room">
                                    <option value=""></option>
                                    <option value="A1">A1</option>
                                    <option value="A2">A2</option>
                                    <option value="B1">B1</option>
                                    <option value="B3">B3</option>
                                    <option value="C2">C2</option>
                                </select>
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
                            <!-- tags -->
                            <div class="flex flex-middle">
                                <div class="tag">
                                    <span>Denis Villeneuve</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex">
                            <label class="field">
                                <span>Staring</span>
                                <input type="text">
                            </label>
                            <button class="button">Add</button>
                            <!-- tags -->
                            <div class="flex flex-middle">
                                <div class="tag">
                                    <span>Ryan Gosling</span>
                                </div>
                                <div class="tag">
                                    <span>Harrison Ford</span>
                                </div>
                            </div>
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
                            <div class="flex flex-middle">
                                <div class="tag">
                                    <span>Action</span>
                                </div>
                                <div class="tag">
                                    <span>Drama</span>
                                </div>
                                <div class="tag">
                                    <span>Mystery</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 flex-column flex-bottom">
                    <div class="flex-column flex-top">
                        <h1>Movie Cover</h1>
                        <label for="upload">
                            <div class="image-input-portrait">
                                <span>+</span>
                            </div>
                        </label>
                        <input type="file" style="display: none;" id="upload">

                    </div>
                </div>
            </div>
            <!-- submit buttons -->
            <div class="container flex flex-center my-l">
                <button class="button button--success">Confirm</button>
                <button class="button button--danger">Cancel</button>
            </div>
        </form>
    <?php endif;
