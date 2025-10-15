<div class="row g-3">

  {{-- Region --}}
  <div class="mb-3 col-md-4">
    <label class="form-label">Region</label>
    <select name="region" class="form-select" required>
    <option value="">Select...</option>

    <option value="Albania" {{ old('region',$pricing_logic->region ?? '')=='Albania' ? 'selected' : '' }}>Albania</option>
    <option value="Algeria" {{ old('region',$pricing_logic->region ?? '')=='Algeria' ? 'selected' : '' }}>Algeria</option>
    <option value="Angola" {{ old('region',$pricing_logic->region ?? '')=='Angola' ? 'selected' : '' }}>Angola</option>
    <option value="Antigua and Barbuda" {{ old('region',$pricing_logic->region ?? '')=='Antigua and Barbuda' ? 'selected' : '' }}>Antigua and Barbuda</option>
    <option value="Argentina" {{ old('region',$pricing_logic->region ?? '')=='Argentina' ? 'selected' : '' }}>Argentina</option>
    <option value="ARIPO" {{ old('region',$pricing_logic->region ?? '')=='ARIPO' ? 'selected' : '' }}>ARIPO</option>
    <option value="Armenia" {{ old('region',$pricing_logic->region ?? '')=='Armenia' ? 'selected' : '' }}>Armenia</option>
    <option value="Australia" {{ old('region',$pricing_logic->region ?? '')=='Australia' ? 'selected' : '' }}>Australia</option>
    <option value="Austria" {{ old('region',$pricing_logic->region ?? '')=='Austria' ? 'selected' : '' }}>Austria</option>
    <option value="Azerbaijan" {{ old('region',$pricing_logic->region ?? '')=='Azerbaijan' ? 'selected' : '' }}>Azerbaijan</option>
    <option value="Bahrain" {{ old('region',$pricing_logic->region ?? '')=='Bahrain' ? 'selected' : '' }}>Bahrain</option>
    <option value="Barbados" {{ old('region',$pricing_logic->region ?? '')=='Barbados' ? 'selected' : '' }}>Barbados</option>
    <option value="Belarus" {{ old('region',$pricing_logic->region ?? '')=='Belarus' ? 'selected' : '' }}>Belarus</option>
    <option value="Belgium" {{ old('region',$pricing_logic->region ?? '')=='Belgium' ? 'selected' : '' }}>Belgium</option>
    <option value="Belize" {{ old('region',$pricing_logic->region ?? '')=='Belize' ? 'selected' : '' }}>Belize</option>
    <option value="Benin" {{ old('region',$pricing_logic->region ?? '')=='Benin' ? 'selected' : '' }}>Benin</option>
    <option value="Bosnia and Herzegovina" {{ old('region',$pricing_logic->region ?? '')=='Bosnia and Herzegovina' ? 'selected' : '' }}>Bosnia and Herzegovina</option>
    <option value="Botswana" {{ old('region',$pricing_logic->region ?? '')=='Botswana' ? 'selected' : '' }}>Botswana</option>
    <option value="Brazil" {{ old('region',$pricing_logic->region ?? '')=='Brazil' ? 'selected' : '' }}>Brazil</option>
    <option value="Brunei Darussalam" {{ old('region',$pricing_logic->region ?? '')=='Brunei Darussalam' ? 'selected' : '' }}>Brunei Darussalam</option>
    <option value="Bulgaria" {{ old('region',$pricing_logic->region ?? '')=='Bulgaria' ? 'selected' : '' }}>Bulgaria</option>
    <option value="Burkina Faso" {{ old('region',$pricing_logic->region ?? '')=='Burkina Faso' ? 'selected' : '' }}>Burkina Faso</option>
    <option value="Cabo Verde" {{ old('region',$pricing_logic->region ?? '')=='Cabo Verde' ? 'selected' : '' }}>Cabo Verde</option>
    <option value="Cambodia" {{ old('region',$pricing_logic->region ?? '')=='Cambodia' ? 'selected' : '' }}>Cambodia</option>
    <option value="Cameroon" {{ old('region',$pricing_logic->region ?? '')=='Cameroon' ? 'selected' : '' }}>Cameroon</option>
    <option value="Canada" {{ old('region',$pricing_logic->region ?? '')=='Canada' ? 'selected' : '' }}>Canada</option>
    <option value="Central African Republic" {{ old('region',$pricing_logic->region ?? '')=='Central African Republic' ? 'selected' : '' }}>Central African Republic</option>
    <option value="Chad" {{ old('region',$pricing_logic->region ?? '')=='Chad' ? 'selected' : '' }}>Chad</option>
    <option value="Chile" {{ old('region',$pricing_logic->region ?? '')=='Chile' ? 'selected' : '' }}>Chile</option>
    <option value="China" {{ old('region',$pricing_logic->region ?? '')=='China' ? 'selected' : '' }}>China</option>
    <option value="Colombia" {{ old('region',$pricing_logic->region ?? '')=='Colombia' ? 'selected' : '' }}>Colombia</option>
    <option value="Comoros" {{ old('region',$pricing_logic->region ?? '')=='Comoros' ? 'selected' : '' }}>Comoros</option>
    <option value="Congo" {{ old('region',$pricing_logic->region ?? '')=='Congo' ? 'selected' : '' }}>Congo</option>
    <option value="Costa Rica" {{ old('region',$pricing_logic->region ?? '')=='Costa Rica' ? 'selected' : '' }}>Costa Rica</option>
    <option value="Côte d’Ivoire" {{ old('region',$pricing_logic->region ?? '')=="Côte d’Ivoire" ? 'selected' : '' }}>Côte d’Ivoire</option>
    <option value="Croatia" {{ old('region',$pricing_logic->region ?? '')=='Croatia' ? 'selected' : '' }}>Croatia</option>
    <option value="Cyprus" {{ old('region',$pricing_logic->region ?? '')=='Cyprus' ? 'selected' : '' }}>Cyprus</option>
    <option value="Czechia" {{ old('region',$pricing_logic->region ?? '')=='Czechia' ? 'selected' : '' }}>Czechia</option>
    <option value="Denmark" {{ old('region',$pricing_logic->region ?? '')=='Denmark' ? 'selected' : '' }}>Denmark</option>
    <option value="Djibouti" {{ old('region',$pricing_logic->region ?? '')=='Djibouti' ? 'selected' : '' }}>Djibouti</option>
    <option value="Dominica" {{ old('region',$pricing_logic->region ?? '')=='Dominica' ? 'selected' : '' }}>Dominica</option>
    <option value="Dominican Republic" {{ old('region',$pricing_logic->region ?? '')=='Dominican Republic' ? 'selected' : '' }}>Dominican Republic</option>
    <option value="Ecuador" {{ old('region',$pricing_logic->region ?? '')=='Ecuador' ? 'selected' : '' }}>Ecuador</option>
    <option value="Egypt" {{ old('region',$pricing_logic->region ?? '')=='Egypt' ? 'selected' : '' }}>Egypt</option>
    <option value="El Salvador" {{ old('region',$pricing_logic->region ?? '')=='El Salvador' ? 'selected' : '' }}>El Salvador</option>
    <option value="Equatorial Guinea" {{ old('region',$pricing_logic->region ?? '')=='Equatorial Guinea' ? 'selected' : '' }}>Equatorial Guinea</option>
    <option value="Estonia" {{ old('region',$pricing_logic->region ?? '')=='Estonia' ? 'selected' : '' }}>Estonia</option>
    <option value="Eswatini" {{ old('region',$pricing_logic->region ?? '')=='Eswatini' ? 'selected' : '' }}>Eswatini</option>
    <option value="Eurasia" {{ old('region',$pricing_logic->region ?? '')=='Eurasia' ? 'selected' : '' }}>Eurasia</option>
    <option value="Europe" {{ old('region',$pricing_logic->region ?? '')=='Europe' ? 'selected' : '' }}>Europe</option>
    <option value="Finland" {{ old('region',$pricing_logic->region ?? '')=='Finland' ? 'selected' : '' }}>Finland</option>
    <option value="France" {{ old('region',$pricing_logic->region ?? '')=='France' ? 'selected' : '' }}>France</option>
    <option value="Gabon" {{ old('region',$pricing_logic->region ?? '')=='Gabon' ? 'selected' : '' }}>Gabon</option>
    <option value="Gambia" {{ old('region',$pricing_logic->region ?? '')=='Gambia' ? 'selected' : '' }}>Gambia</option>
    <option value="Georgia" {{ old('region',$pricing_logic->region ?? '')=='Georgia' ? 'selected' : '' }}>Georgia</option>
    <option value="Germany" {{ old('region',$pricing_logic->region ?? '')=='Germany' ? 'selected' : '' }}>Germany</option>
    <option value="Ghana" {{ old('region',$pricing_logic->region ?? '')=='Ghana' ? 'selected' : '' }}>Ghana</option>
    <option value="Greece" {{ old('region',$pricing_logic->region ?? '')=='Greece' ? 'selected' : '' }}>Greece</option>
    <option value="Grenada" {{ old('region',$pricing_logic->region ?? '')=='Grenada' ? 'selected' : '' }}>Grenada</option>
    <option value="Guatemala" {{ old('region',$pricing_logic->region ?? '')=='Guatemala' ? 'selected' : '' }}>Guatemala</option>
    <option value="Guinea" {{ old('region',$pricing_logic->region ?? '')=='Guinea' ? 'selected' : '' }}>Guinea</option>
    <option value="Guinea-Bissau" {{ old('region',$pricing_logic->region ?? '')=='Guinea-Bissau' ? 'selected' : '' }}>Guinea-Bissau</option>
    <option value="Honduras" {{ old('region',$pricing_logic->region ?? '')=='Honduras' ? 'selected' : '' }}>Honduras</option>
    <option value="Hungary" {{ old('region',$pricing_logic->region ?? '')=='Hungary' ? 'selected' : '' }}>Hungary</option>
    <option value="Iceland" {{ old('region',$pricing_logic->region ?? '')=='Iceland' ? 'selected' : '' }}>Iceland</option>
    <option value="India" {{ old('region',$pricing_logic->region ?? '')=='India' ? 'selected' : '' }}>India</option>
    <option value="Indonesia" {{ old('region',$pricing_logic->region ?? '')=='Indonesia' ? 'selected' : '' }}>Indonesia</option>
    <option value="Ireland" {{ old('region',$pricing_logic->region ?? '')=='Ireland' ? 'selected' : '' }}>Ireland</option>
    <option value="Israel" {{ old('region',$pricing_logic->region ?? '')=='Israel' ? 'selected' : '' }}>Israel</option>
    <option value="Italy" {{ old('region',$pricing_logic->region ?? '')=='Italy' ? 'selected' : '' }}>Italy</option>
    <option value="Jamaica" {{ old('region',$pricing_logic->region ?? '')=='Jamaica' ? 'selected' : '' }}>Jamaica</option>
    <option value="Japan" {{ old('region',$pricing_logic->region ?? '')=='Japan' ? 'selected' : '' }}>Japan</option>
    <option value="Jordan" {{ old('region',$pricing_logic->region ?? '')=='Jordan' ? 'selected' : '' }}>Jordan</option>
    <option value="Kazakhstan" {{ old('region',$pricing_logic->region ?? '')=='Kazakhstan' ? 'selected' : '' }}>Kazakhstan</option>
    <option value="Kenya" {{ old('region',$pricing_logic->region ?? '')=='Kenya' ? 'selected' : '' }}>Kenya</option>
    <option value="Kuwait" {{ old('region',$pricing_logic->region ?? '')=='Kuwait' ? 'selected' : '' }}>Kuwait</option>
    <option value="Kyrgyzstan" {{ old('region',$pricing_logic->region ?? '')=='Kyrgyzstan' ? 'selected' : '' }}>Kyrgyzstan</option>
    <option value="Lao PDR" {{ old('region',$pricing_logic->region ?? '')=='Lao PDR' ? 'selected' : '' }}>Lao People’s Democratic Republic</option>
    <option value="Latvia" {{ old('region',$pricing_logic->region ?? '')=='Latvia' ? 'selected' : '' }}>Latvia</option>
    <option value="Lesotho" {{ old('region',$pricing_logic->region ?? '')=='Lesotho' ? 'selected' : '' }}>Lesotho</option>
    <option value="Liberia" {{ old('region',$pricing_logic->region ?? '')=='Liberia' ? 'selected' : '' }}>Liberia</option>
    <option value="Liechtenstein" {{ old('region',$pricing_logic->region ?? '')=='Liechtenstein' ? 'selected' : '' }}>Liechtenstein</option>
    <option value="Lithuania" {{ old('region',$pricing_logic->region ?? '')=='Lithuania' ? 'selected' : '' }}>Lithuania</option>
    <option value="Luxembourg" {{ old('region',$pricing_logic->region ?? '')=='Luxembourg' ? 'selected' : '' }}>Luxembourg</option>
    <option value="Madagascar" {{ old('region',$pricing_logic->region ?? '')=='Madagascar' ? 'selected' : '' }}>Madagascar</option>
    <option value="Malawi" {{ old('region',$pricing_logic->region ?? '')=='Malawi' ? 'selected' : '' }}>Malawi</option>
    <option value="Malaysia" {{ old('region',$pricing_logic->region ?? '')=='Malaysia' ? 'selected' : '' }}>Malaysia</option>
    <option value="Mali" {{ old('region',$pricing_logic->region ?? '')=='Mali' ? 'selected' : '' }}>Mali</option>
    <option value="Malta" {{ old('region',$pricing_logic->region ?? '')=='Malta' ? 'selected' : '' }}>Malta</option>
    <option value="Mauritania" {{ old('region',$pricing_logic->region ?? '')=='Mauritania' ? 'selected' : '' }}>Mauritania</option>
    <option value="Mauritius" {{ old('region',$pricing_logic->region ?? '')=='Mauritius' ? 'selected' : '' }}>Mauritius</option>
    <option value="Mexico" {{ old('region',$pricing_logic->region ?? '')=='Mexico' ? 'selected' : '' }}>Mexico</option>
    <option value="Monaco" {{ old('region',$pricing_logic->region ?? '')=='Monaco' ? 'selected' : '' }}>Monaco</option>
    <option value="Mongolia" {{ old('region',$pricing_logic->region ?? '')=='Mongolia' ? 'selected' : '' }}>Mongolia</option>
    <option value="Montenegro" {{ old('region',$pricing_logic->region ?? '')=='Montenegro' ? 'selected' : '' }}>Montenegro</option>
    <option value="Morocco" {{ old('region',$pricing_logic->region ?? '')=='Morocco' ? 'selected' : '' }}>Morocco</option>
    <option value="Mozambique" {{ old('region',$pricing_logic->region ?? '')=='Mozambique' ? 'selected' : '' }}>Mozambique</option>
    <option value="Namibia" {{ old('region',$pricing_logic->region ?? '')=='Namibia' ? 'selected' : '' }}>Namibia</option>
    <option value="Netherlands" {{ old('region',$pricing_logic->region ?? '')=='Netherlands' ? 'selected' : '' }}>Netherlands</option>
    <option value="New Zealand" {{ old('region',$pricing_logic->region ?? '')=='New Zealand' ? 'selected' : '' }}>New Zealand</option>
    <option value="Nicaragua" {{ old('region',$pricing_logic->region ?? '')=='Nicaragua' ? 'selected' : '' }}>Nicaragua</option>
    <option value="Niger" {{ old('region',$pricing_logic->region ?? '')=='Niger' ? 'selected' : '' }}>Niger</option>
    <option value="Nigeria" {{ old('region',$pricing_logic->region ?? '')=='Nigeria' ? 'selected' : '' }}>Nigeria</option>
    <option value="North Macedonia" {{ old('region',$pricing_logic->region ?? '')=='North Macedonia' ? 'selected' : '' }}>North Macedonia</option>
    <option value="Norway" {{ old('region',$pricing_logic->region ?? '')=='Norway' ? 'selected' : '' }}>Norway</option>
    <option value="OAPI" {{ old('region',$pricing_logic->region ?? '')=='OAPI' ? 'selected' : '' }}>OAPI</option>
    <option value="Oman" {{ old('region',$pricing_logic->region ?? '')=='Oman' ? 'selected' : '' }}>Oman</option>
    <option value="Panama" {{ old('region',$pricing_logic->region ?? '')=='Panama' ? 'selected' : '' }}>Panama</option>
    <option value="Papua New Guinea" {{ old('region',$pricing_logic->region ?? '')=='Papua New Guinea' ? 'selected' : '' }}>Papua New Guinea</option>
    <option value="Peru" {{ old('region',$pricing_logic->region ?? '')=='Peru' ? 'selected' : '' }}>Peru</option>
    <option value="Philippines" {{ old('region',$pricing_logic->region ?? '')=='Philippines' ? 'selected' : '' }}>Philippines</option>
    <option value="Poland" {{ old('region',$pricing_logic->region ?? '')=='Poland' ? 'selected' : '' }}>Poland</option>
    <option value="Portugal" {{ old('region',$pricing_logic->region ?? '')=='Portugal' ? 'selected' : '' }}>Portugal</option>
    <option value="Qatar" {{ old('region',$pricing_logic->region ?? '')=='Qatar' ? 'selected' : '' }}>Qatar</option>
    <option value="Republic of Korea" {{ old('region',$pricing_logic->region ?? '')=='Republic of Korea' ? 'selected' : '' }}>Republic of Korea</option>
    <option value="Republic of Moldova" {{ old('region',$pricing_logic->region ?? '')=='Republic of Moldova' ? 'selected' : '' }}>Republic of Moldova</option>
    <option value="Romania" {{ old('region',$pricing_logic->region ?? '')=='Romania' ? 'selected' : '' }}>Romania</option>
    <option value="Russia" {{ old('region',$pricing_logic->region ?? '')=='Russian Federation' ? 'selected' : '' }}>Russian Federation</option>
    <option value="Rwanda" {{ old('region',$pricing_logic->region ?? '')=='Rwanda' ? 'selected' : '' }}>Rwanda</option>
    <option value="San Marino" {{ old('region',$pricing_logic->region ?? '')=='San Marino' ? 'selected' : '' }}>San Marino</option>
    <option value="Sao Tome and Principe" {{ old('region',$pricing_logic->region ?? '')=='Sao Tome and Principe' ? 'selected' : '' }}>Sao Tome and Principe</option>
    <option value="Saudi Arabia" {{ old('region',$pricing_logic->region ?? '')=='Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
    <option value="Senegal" {{ old('region',$pricing_logic->region ?? '')=='Senegal' ? 'selected' : '' }}>Senegal</option>
    <option value="Serbia" {{ old('region',$pricing_logic->region ?? '')=='Serbia' ? 'selected' : '' }}>Serbia</option>
    <option value="Seychelles" {{ old('region',$pricing_logic->region ?? '')=='Seychelles' ? 'selected' : '' }}>Seychelles</option>
    <option value="Singapore" {{ old('region',$pricing_logic->region ?? '')=='Singapore' ? 'selected' : '' }}>Singapore</option>
    <option value="Slovakia" {{ old('region',$pricing_logic->region ?? '')=='Slovakia' ? 'selected' : '' }}>Slovakia</option>
    <option value="Slovenia" {{ old('region',$pricing_logic->region ?? '')=='Slovenia' ? 'selected' : '' }}>Slovenia</option>
    <option value="South Africa" {{ old('region',$pricing_logic->region ?? '')=='South Africa' ? 'selected' : '' }}>South Africa</option>
    <option value="Spain" {{ old('region',$pricing_logic->region ?? '')=='Spain' ? 'selected' : '' }}>Spain</option>
    <option value="Sri Lanka" {{ old('region',$pricing_logic->region ?? '')=='Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
    <option value="Sudan" {{ old('region',$pricing_logic->region ?? '')=='Sudan' ? 'selected' : '' }}>Sudan</option>
    <option value="Sweden" {{ old('region',$pricing_logic->region ?? '')=='Sweden' ? 'selected' : '' }}>Sweden</option>
    <option value="Switzerland" {{ old('region',$pricing_logic->region ?? '')=='Switzerland' ? 'selected' : '' }}>Switzerland</option>
    <option value="Syrian Arab Republic" {{ old('region',$pricing_logic->region ?? '')=='Syrian Arab Republic' ? 'selected' : '' }}>Syrian Arab Republic</option>
    <option value="Tajikistan" {{ old('region',$pricing_logic->region ?? '')=='Tajikistan' ? 'selected' : '' }}>Tajikistan</option>
    <option value="Thailand" {{ old('region',$pricing_logic->region ?? '')=='Thailand' ? 'selected' : '' }}>Thailand</option>
    <option value="Trinidad and Tobago" {{ old('region',$pricing_logic->region ?? '')=='Trinidad and Tobago' ? 'selected' : '' }}>Trinidad and Tobago</option>
    <option value="Tunisia" {{ old('region',$pricing_logic->region ?? '')=='Tunisia' ? 'selected' : '' }}>Tunisia</option>

    <option value="Türkiye" {{ (old('region', $pricing_logic->region ?? '') == 'Türkiye' || old('region', $pricing_logic->region ?? '') == 'Turkey') ? 'selected' : '' }}>Türkiye</option>


    <option value="Turkmenistan" {{ old('region',$pricing_logic->region ?? '')=='Turkmenistan' ? 'selected' : '' }}>Turkmenistan</option>
    <option value="Uganda" {{ old('region',$pricing_logic->region ?? '')=='Uganda' ? 'selected' : '' }}>Uganda</option>
    <option value="Ukraine" {{ old('region',$pricing_logic->region ?? '')=='Ukraine' ? 'selected' : '' }}>Ukraine</option>
    <option value="United Arab Emirates" {{ old('region',$pricing_logic->region ?? '')=='United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
    <option value="United Kingdom" {{ old('region',$pricing_logic->region ?? '')=='United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
    <option value="Tanzania" {{ old('region',$pricing_logic->region ?? '')=='United Republic of Tanzania' ? 'selected' : '' }}>United Republic of Tanzania</option>
    <option value="United States of America" {{ old('region',$pricing_logic->region ?? '')=='United States of America' ? 'selected' : '' }}>United States of America</option>
    <option value="Uruguay" {{ old('region',$pricing_logic->region ?? '')=='Uruguay' ? 'selected' : '' }}>Uruguay</option>
    <option value="Uzbekistan" {{ old('region',$pricing_logic->region ?? '')=='Uzbekistan' ? 'selected' : '' }}>Uzbekistan</option>
    <option value="Venezuela" {{ old('region',$pricing_logic->region ?? '')=='Venezuela' ? 'selected' : '' }}>Venezuela</option>
    <option value="Viet Nam" {{ old('region',$pricing_logic->region ?? '')=='Viet Nam' ? 'selected' : '' }}>Viet Nam</option>
    <option value="Zambia" {{ old('region',$pricing_logic->region ?? '')=='Zambia' ? 'selected' : '' }}>Zambia</option>
    <option value="Zimbabwe" {{ old('region',$pricing_logic->region ?? '')=='Zimbabwe' ? 'selected' : '' }}>Zimbabwe</option>
</select>

    @error('region') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Service --}}
  <div class="mb-3 col-md-4">
    <label class="form-label">Service</label>
    <select name="service" class="form-select" required>
      <option value="">Select...</option>
      <option value="pct_national_phase" {{ old('service',$pricing_logic->service ?? '')=='pct_national_phase' ? 'selected' : '' }}>PCT National Phase Filing</option>
      <option value="direct_filing" {{ old('service',$pricing_logic->service ?? '')=='direct_filing' ? 'selected' : '' }}>Direct Filing / Paris Convention</option>
      <option value="trademark" {{ old('service',$pricing_logic->service ?? '')=='trademark' ? 'selected' : '' }}>Trademark</option>
      <option value="design" {{ old('service',$pricing_logic->service ?? '')=='design' ? 'selected' : '' }}>Design</option>
      <option value="ep_validation" {{ old('service',$pricing_logic->service ?? '')=='ep_validation' ? 'selected' : '' }}>EP Validation</option>
      <option value="recordal" {{ old('service',$pricing_logic->service ?? '')=='recordal' ? 'selected' : '' }}>Recordal / Assignment</option>
      <option value="provisional_refusal" {{ old('service',$pricing_logic->service ?? '')=='provisional_refusal' ? 'selected' : '' }}>Provisional Refusal</option>
    </select>
    @error('service') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>




{{-- translation --}}
  <div class="mb-3 col-md-4">
    <label class="form-label">Translation</label>
    <select name="translation" class="form-select" required>
      <option value="">Select...</option>
      <option value="claims" {{ old('service',$pricing_logic->translation ?? '')=='claims' ? 'selected' : '' }}>Only Claims</option>
      <option value="full" {{ old('service',$pricing_logic->translation ?? '')=='full' ? 'selected' : '' }}>Full Translation</option>
      <option value="no" {{ old('service',$pricing_logic->translation ?? '')=='' ? 'selected' : '' }}>No Translation</option>
      
    </select>
    @error('service') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Country --}}
  <div class="mb-3 col-md-4">
    <label class="form-label">Country Code</label>
    <input type="text" name="country" class="form-control" value="{{ old('country', $pricing_logic->country ?? '') }}" placeholder="e.g. US" required>
    @error('country') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Language --}}
  <div class="mb-3 col-md-4">
    <label class="form-label">Language</label>
    <input type="text" name="language" class="form-control" value="{{ old('language', $pricing_logic->language ?? '') }}" placeholder="e.g. English" required>
    @error('language') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Filing Fee --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Filing Fee</label>
    <input type="number" step="0.01" name="filing_fee" class="form-control" value="{{ old('filing_fee', $pricing_logic->filing_fee ?? '') }}" required>
    @error('filing_fee') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Translation Fee --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Translation Fee</label>
    <input type="number" step="0.01" name="translation_fee" class="form-control" value="{{ old('translation_fee', $pricing_logic->translation_fee ?? '') }}" required>
    @error('translation_fee') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Official Fee --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Official Fee</label>
    <input type="number" step="0.01" name="official_fee" class="form-control" value="{{ old('official_fee', $pricing_logic->official_fee ?? '') }}" required>
    @error('official_fee') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Excess Claims Fee --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Excess Claims Fee (per claim)</label>
    <input type="number" step="0.01" name="excess_claim_fee" class="form-control" value="{{ old('excess_claim_fee', $pricing_logic->excess_claim_fee ?? '') }}" required>
    @error('excess_claim_fee') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Claims Threshold --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Claims Threshold</label>
    <input type="number" step="1" name="claims_threshold" class="form-control" value="{{ old('claims_threshold', $pricing_logic->claims_threshold ?? 0) }}" required>
    @error('claims_threshold') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Excess Pages Fee --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Excess Pages Fee (per page)</label>
    <input type="number" step="0.01" name="excess_page_fee" class="form-control" value="{{ old('excess_page_fee', $pricing_logic->excess_page_fee ?? '') }}" required>
    @error('excess_page_fee') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Pages Threshold --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Pages Threshold</label>
    <input type="number" step="1" name="pages_threshold" class="form-control" value="{{ old('pages_threshold', $pricing_logic->pages_threshold ?? 0) }}" required>
    @error('pages_threshold') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Priority Fee --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Priority Fee (per priority)</label>
    <input type="number" step="0.01" name="priority_fee" class="form-control" value="{{ old('priority_fee', $pricing_logic->priority_fee ?? '') }}" required>
    @error('priority_fee') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Priority Threshold --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Priority Threshold</label>
    <input type="number" step="1" name="priority_threshold" class="form-control" value="{{ old('priority_threshold', $pricing_logic->priority_threshold ?? 0) }}" required>
    @error('priority_threshold') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Drawing Fee (small) --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Drawing Fee (small)</label>
    <input type="number" step="0.01" name="drawing_fee_small" class="form-control" value="{{ old('drawing_fee_small', $pricing_logic->drawing_fee_small ?? '') }}" required>
    @error('drawing_fee_small') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Drawing Small Threshold --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Drawing Small Threshold</label>
    <input type="number" step="1" name="drawing_small_threshold" class="form-control" value="{{ old('drawing_small_threshold', $pricing_logic->drawing_small_threshold ?? 0) }}" required>
    @error('drawing_small_threshold') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Drawing Fee (large) --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Drawing Fee (large)</label>
    <input type="number" step="0.01" name="drawing_fee_large" class="form-control" value="{{ old('drawing_fee_large', $pricing_logic->drawing_fee_large ?? '') }}" required>
    @error('drawing_fee_large') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Drawing Large Threshold --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Drawing Large Threshold</label>
    <input type="number" step="1" name="drawing_large_threshold" class="form-control" value="{{ old('drawing_large_threshold', $pricing_logic->drawing_large_threshold ?? 0) }}" required>
    @error('drawing_large_threshold') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Per Sequence Page Fee --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Per Sequence Page Fee</label>
    <input type="number" step="0.01" name="per_sequence_page_fee" class="form-control" value="{{ old('per_sequence_page_fee', $pricing_logic->per_sequence_page_fee ?? 0) }}" required>
    @error('per_sequence_page_fee') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Special Rules --}}
  <div class="col-md-12 mb-3">
    <label class="form-label">Special Rules / Notes</label>
    <textarea name="special_rules" class="form-control" rows="3" required>{{ old('special_rules', $pricing_logic->special_rules ?? '') }}</textarea>
    @error('special_rules') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Tax --}}
  <div class="col-md-3 mb-3">
    <label class="form-label">Tax %</label>
    <input type="number" step="0.01" name="tax_percentage" class="form-control" value="{{ old('tax_percentage', $pricing_logic->tax_percentage ?? 0) }}" required>
    @error('tax_percentage') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Status --}}
  <div class="col-md-3 mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select" required>
      <option value="active" {{ (old('status', $pricing_logic->status ?? '')=='active') ? 'selected' : '' }}>Active</option>
      <option value="inactive" {{ (old('status', $pricing_logic->status ?? '')=='inactive') ? 'selected' : '' }}>Inactive</option>
    </select>
    @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

</div>
