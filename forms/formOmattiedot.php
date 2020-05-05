<div class="valikkoSivuWrapper">
    <div class="valikkoSivuNavNimi">OMAT TIEDOT</div>
    <div class="valikkoSivuNavKuvake">
        <i id="closeOmattiedot" class='fas fa-times-circle'></i>
    </div>
    <div class="valikkoSivuBody">
        <form method="post">
        <div class="checkboxDiv2"><p class="textGeneric">Sähköposti</p><input type="text" class="textboxGeneric" name="email" value="<?php echo $_SESSION['got_email'];?>"></div>
        <div class="checkboxDiv2"><p class="textGeneric">Etunimi</p><input type="text" class="textboxGeneric" name="first_name" value="<?php echo $_SESSION['got_first_name'];?>"></div>
        <div class="checkboxDiv2"><p class="textGeneric">Sukunimi</p><input type="text" class="textboxGeneric" name="last_name" value="<?php echo $_SESSION['got_last_name'];?>"></div>
        <div class="checkboxDiv2"><p class="textGeneric">Sukupuoli</p><input type="text" class="textboxGeneric" name="gender" list="gender" value="<?php echo $_SESSION['got_gender'];?>"></div>
            <datalist id="gender">
            <option value="MIES">
            <option value="NAINEN">
            </datalist>
        <div class="checkboxDiv2"><p class="textGeneric">Pituus</p><input type="text" class="textboxGeneric" name="height" list="height" value="<?php echo $_SESSION['got_height'];?>"></div>
            <datalist id="height">
            <option value="100"><option value="101"><option value="102"><option value="103"><option value="104"><option value="105"><option value="106"><option value="107"><option value="108"><option value="109">
            <option value="110"><option value="111"><option value="112"><option value="113"><option value="114"><option value="115"><option value="116"><option value="117"><option value="118"><option value="119">
            <option value="120"><option value="121"><option value="122"><option value="123"><option value="124"><option value="125"><option value="126"><option value="127"><option value="128"><option value="129">
            <option value="130"><option value="131"><option value="132"><option value="133"><option value="134"><option value="135"><option value="136"><option value="137"><option value="138"><option value="139">
            <option value="140"><option value="141"><option value="142"><option value="143"><option value="144"><option value="145"><option value="146"><option value="147"><option value="148"><option value="149">
            <option value="150"><option value="151"><option value="152"><option value="153"><option value="154"><option value="155"><option value="156"><option value="157"><option value="158"><option value="159">
            <option value="160"><option value="161"><option value="162"><option value="163"><option value="164"><option value="165"><option value="166"><option value="167"><option value="168"><option value="169">
            <option value="170"><option value="171"><option value="172"><option value="173"><option value="174"><option value="175"><option value="176"><option value="177"><option value="178"><option value="179">
            <option value="180"><option value="181"><option value="182"><option value="183"><option value="184"><option value="185"><option value="186"><option value="187"><option value="188"><option value="189">
            <option value="190"><option value="191"><option value="192"><option value="193"><option value="194"><option value="195"><option value="196"><option value="197"><option value="198"><option value="199">
            <option value="200"><option value="201"><option value="202"><option value="203"><option value="204"><option value="205"><option value="206"><option value="207"><option value="208"><option value="209">
            <option value="210"><option value="211"><option value="212"><option value="213"><option value="214"><option value="215"><option value="216"><option value="217"><option value="218"><option value="219">
            <option value="220"><option value="221"><option value="222"><option value="223"><option value="224"><option value="225"><option value="226"><option value="227"><option value="228"><option value="229">
            <option value="230"><option value="231"><option value="232"><option value="233"><option value="234"><option value="235"><option value="236"><option value="237"><option value="238"><option value="239">
            </datalist>     
        <div class="checkboxDiv2"><p class="textGeneric">Paino</p><input type="text" class="textboxGeneric" name="weight" list="weight" value="<?php echo $_SESSION['got_weight'];?>"></div>
            <datalist id="weight">
            <option value="20"><option value="21"><option value="22"><option value="23"><option value="24"><option value="25"><option value="26"><option value="27"><option value="28"><option value="29">
            <option value="30"><option value="31"><option value="32"><option value="33"><option value="34"><option value="35"><option value="36"><option value="37"><option value="38"><option value="39">
            <option value="40"><option value="41"><option value="42"><option value="43"><option value="44"><option value="45"><option value="46"><option value="47"><option value="48"><option value="49">
            <option value="50"><option value="51"><option value="52"><option value="53"><option value="54"><option value="55"><option value="56"><option value="57"><option value="58"><option value="59">
            <option value="60"><option value="61"><option value="62"><option value="63"><option value="64"><option value="65"><option value="66"><option value="67"><option value="68"><option value="69">
            <option value="70"><option value="71"><option value="72"><option value="73"><option value="74"><option value="75"><option value="76"><option value="77"><option value="78"><option value="79">
            <option value="80"><option value="81"><option value="82"><option value="83"><option value="84"><option value="85"><option value="86"><option value="87"><option value="88"><option value="89">
            <option value="90"><option value="91"><option value="92"><option value="93"><option value="94"><option value="95"><option value="96"><option value="97"><option value="98"><option value="99">
            <option value="100"><option value="101"><option value="102"><option value="103"><option value="104"><option value="105"><option value="106"><option value="107"><option value="108"><option value="109">
            <option value="110"><option value="111"><option value="112"><option value="113"><option value="114"><option value="115"><option value="116"><option value="117"><option value="118"><option value="119">
            <option value="120"><option value="121"><option value="122"><option value="123"><option value="124"><option value="125"><option value="126"><option value="127"><option value="128"><option value="129">
            <option value="130"><option value="131"><option value="132"><option value="133"><option value="134"><option value="135"><option value="136"><option value="137"><option value="138"><option value="139">
            <option value="140"><option value="141"><option value="142"><option value="143"><option value="144"><option value="145"><option value="146"><option value="147"><option value="148"><option value="149">
            <option value="150"><option value="151"><option value="152"><option value="153"><option value="154"><option value="155"><option value="156"><option value="157"><option value="158"><option value="159">
            <option value="160"><option value="161"><option value="162"><option value="163"><option value="164"><option value="165"><option value="166"><option value="167"><option value="168"><option value="169">
            <option value="170"><option value="171"><option value="172"><option value="173"><option value="174"><option value="175"><option value="176"><option value="177"><option value="178"><option value="179">
            <option value="180"><option value="181"><option value="182"><option value="183"><option value="184"><option value="185"><option value="186"><option value="187"><option value="188"><option value="189">
            <option value="190"><option value="191"><option value="192"><option value="193"><option value="194"><option value="195"><option value="196"><option value="197"><option value="198"><option value="199">
            </datalist>    
        <div class="checkboxDiv2"><p class="textGeneric">Syntymäaika</p><input type="date" class="textboxGeneric" name="birthdate" value="<?php echo $_SESSION['got_birthday'];?>"></div>
            <br>
        <div class="checkboxDiv"><p class="textGeneric">Käytän kofeiinituotteita</p><input type="checkbox" class="checkboxGeneric" name="stimulants" <?php echo $_SESSION['got_parameters_stimulants_checked'];?>></div>
        <div class="checkboxDiv"><p class="textGeneric">Käytän alkoholia</p><input type="checkbox" class="checkboxGeneric" name="alcohol" <?php echo $_SESSION['got_parameters_alcohol_checked'];?>></div>
        <div class="checkboxDiv"><p class="textGeneric">Käytän unilääkkeitä</p><input type="checkbox" class="checkboxGeneric" name="medicine" <?php echo $_SESSION['got_parameters_medicine_checked'];?>></div>
        <div class="checkboxDiv"><p class="textGeneric">Käytän huumeita</p><input type="checkbox" class="checkboxGeneric" name="drugs" <?php echo $_SESSION['got_parameters_drug_checked'];?>></div>
        <div class="checkboxDiv"><p class="textGeneric">Käytän tietokonetta/kännykkää</p><input type="checkbox" class="checkboxGeneric" name="screen_time" <?php echo $_SESSION['got_parameters_screen_time_checked'];?>></div>
        <div class="checkboxDiv"><p class="textGeneric">Käytän nikotiinituotteita</p><input type="checkbox" class="checkboxGeneric" name="cigarette" <?php echo $_SESSION['got_parameters_smoke_checked'];?>></div>
            <br>
        <div class="checkboxDiv"><p class="textGeneric">Hyväksyn...</p></div>
        <div class="checkboxDiv"><p class="textGeneric">...käyttöehdot</p><input type="checkbox" class="checkboxGeneric" name="user_agreement" <?php echo $_SESSION['got_parameters_user_agreement_checked'];?>></div>
        <div class="checkboxDiv"><p class="textGeneric">...henkilötietojen käsittelyn</p><input type="checkbox" class="checkboxGeneric" name="gdpr" <?php echo $_SESSION['got_parameters_gdpr_checked'];?>></div>
        <div class="checkboxDiv"><p class="textGeneric">...sähköpostimarkkinoinnin</p><input type="checkbox" class="checkboxGeneric" name="email_marketing" <?php echo $_SESSION['got_parameters_email_marketing_checked'];?>></div>
            <br>
        <input class="buttonGeneric" type="submit" name="saveUserDetails" value="Tallenna">
        <input class="buttonGeneric" type="reset" value="Peruuta">
        </form>
        <br>
        <br>
    </div>
</div>