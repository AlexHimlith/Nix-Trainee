        <main>
            <form id="form_registration" method="post">
                
                <label><span>First Name:<em>*</em></span>
                    <input type="text" minlength="30" name="f_name" placeholder="John" required>
                </label>
                               
                <label><span>Surname:<em>*</em></span>
                    <input type="text" minlength="30" name="surname" placeholder="Doe" required>
                </label>
                                
                <label><span>Nick:<em>*</em></span>
                    <input type="text" name="nick" placeholder="JDoe" required>
                </label>
                                
                <label><span>E-mail:<em>*</em></span>
                    <input type="email" name="email" placeholder="JohnDoe@gmail.com" required>
                </label>

                <label><span>Date of Borth:</span>
                    <input type="date" name="dat_borth">
                </label>

                <label><span>Place:</span>
                    <input type="text" name="place" placeholder="Kharkov">
                </label>

                <input type="submit" value="Register">

            </form>
        </main>