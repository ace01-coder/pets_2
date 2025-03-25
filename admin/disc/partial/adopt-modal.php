<div class="modal fade" id="adoptModal" tabindex="-1" aria-labelledby="adoptModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="adoptModalLabel">Adoption Application</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
        <form id="adoptionForm" action="submit_adoption.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
          <div class="col">
            <!-- Right Column: Applicant Information -->
            <div class="col-md-8">
              <!-- Section 1: Personal Information -->
              <h6 class="mb-3">Personal Information</h6>
              <div class="row g-3">
                <!-- First Name -->
                <div class="col-md-12">
                  <label for="firstName" class="form-label">Fullname*</label>
                  <input type="text" class="form-control" id="firstName" name="firstName" required>
                  <div class="invalid-feedback">First name is required.</div>
                </div>
                <!-- Address -->
                <div class="col-12">
                  <label for="address" class="form-label">Address*</label>
                  <input type="text" class="form-control" id="address" name="address" required>
                  <div class="invalid-feedback">Address is required.</div>
                </div>
                <!-- Phone -->
                <div class="col-md-6">
                  <label for="phone" class="form-label">Phone*</label>
                  <input type="tel" class="form-control" id="phone" name="phone" required>
                  <div class="invalid-feedback">Phone is required.</div>
                </div>
                <!-- Email -->
                <div class="col-md-6">
                  <label for="email" class="form-label">Email*</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                  <div class="invalid-feedback">Email is required.</div>
                </div>
                <!-- Birth Date -->
                <div class="col-md-6">
                  <label for="birthDate" class="form-label">Birth Date*</label>
                  <input type="date" class="form-control" id="birthDate" name="birthDate" required>
                  <div class="invalid-feedback">Birth date is required.</div>
                </div>
                <!-- Occupation -->
                <div class="col-md-6">
                  <label for="occupation" class="form-label">Occupation</label>
                  <input type="text" class="form-control" id="occupation" name="occupation">
                </div>
              
              </div>
              <!-- End Section 1 -->
              <hr>
              <!-- Section 3: Questionnaire -->
              <hr class="my-4">
              <h6 class="mb-3">Questionnaire</h6>
              <div class="row g-3">

                <!-- Adopted before? -->
                <div class="col-12">
                  <label class="form-label">Have you adopt a pet/s?*</label>
                  <br>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="adoptedBefore" id="adoptedBeforeYes" value="Yes" required>
                    <label class="form-check-label" for="adoptedBeforeYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="adoptedBefore" id="adoptedBeforeNo" value="No" required>
                    <label class="form-check-label" for="adoptedBeforeNo">No</label>
                  </div>
                </div>

                <!-- What are you looking to adopt? -->
                <div class="col-12">
                  <label class="form-label">What are you looking to adopt?*</label>
                  <br>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="lookingToAdopt" id="adoptCat" value="Cat" required>
                    <label class="form-check-label" for="adoptCat">Cat</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="lookingToAdopt" id="adoptDog" value="Dog" required>
                    <label class="form-check-label" for="adoptDog">Dog</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="lookingToAdopt" id="adoptBoth" value="Both" required>
                    <label class="form-check-label" for="adoptBoth">Both</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="lookingToAdopt" id="adoptNotDecided" value="Not Decided" required>
                    <label class="form-check-label" for="adoptNotDecided">Not decided</label>
                  </div>
                </div>
                <!-- Specific animal adoption? -->
                <div class="col-12">
                  <label class="form-label">Are you applying to adopt a specific shelter animal?*</label>
                  <br>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="specificAnimal" id="specificAnimalYes" value="Yes" required>
                    <label class="form-check-label" for="specificAnimalYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="specificAnimal" id="specificAnimalNo" value="No" required>
                    <label class="form-check-label" for="specificAnimalNo">No</label>
                  </div>
                </div>
                <!-- Ideal pet description -->
                <div class="col-12">
                  <label for="idealPetDescription" class="form-label">Describe your ideal pet, including its sex, age, appearance, temperament, etc.*</label>
                  <textarea class="form-control" id="idealPetDescription" name="idealPetDescription" rows="3" required></textarea>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <!-- Building type -->
                <div class="col-12">
                  <label class="form-label">What type of building do you live in?*</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="buildingType" id="buildingHouse" value="House" required>
                    <label class="form-check-label" for="buildingHouse">House</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="buildingType" id="buildingApartment" value="Apartment" required>
                    <label class="form-check-label" for="buildingApartment">Apartment</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="buildingType" id="buildingCondo" value="Condo" required>
                    <label class="form-check-label" for="buildingCondo">Condo</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="buildingType" id="buildingOther" value="Other" required>
                    <label class="form-check-label" for="buildingOther">Other</label>
                  </div>
                </div>
                <!-- Rent -->
                <div class="col-12">
                  <label class="form-label">Do you rent?*</label>
                  <br>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rent" id="rentYes" value="Yes" required>
                    <label class="form-check-label" for="rentYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rent" id="rentNo" value="No" required>
                    <label class="form-check-label" for="rentNo">No</label>
                  </div>
                </div>
                <!-- Pet when move -->
                <div class="col-12">
                  <label for="petWhenMove" class="form-label">What happens to your pet if or when you move?*</label>
                  <input type="text" class="form-control" id="petWhenMove" name="petWhenMove" required>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <!-- Who do you live with -->
                <div class="col-12">
                  <label class="form-label">Who do you live with?*</label>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="liveWith[]" id="liveAlone" value="Living alone">
                    <label class="form-check-label" for="liveAlone">Living alone</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="liveWith[]" id="liveSpouse" value="Spouse">
                    <label class="form-check-label" for="liveSpouse">Spouse</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="liveWith[]" id="liveParents" value="Parents">
                    <label class="form-check-label" for="liveParents">Parents</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="liveWith[]" id="liveChildrenOver" value="Children over 18">
                    <label class="form-check-label" for="liveChildrenOver">Children over 18</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="liveWith[]" id="liveChildrenBelow" value="Children below 18">
                    <label class="form-check-label" for="liveChildrenBelow">Children below 18</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="liveWith[]" id="liveRelatives" value="Relatives">
                    <label class="form-check-label" for="liveRelatives">Relatives</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="liveWith[]" id="liveRoommate" value="Roommate(s)">
                    <label class="form-check-label" for="liveRoommate">Roommate(s)</label>
                  </div>
                </div>
                <br>
                <!-- Allergies -->
                <div class="col-12">
                  <label class="form-label">Are any members of your household allergic to animals?*</label>
                  <br>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="allergic" id="allergicYes" value="Yes" required>
                    <label class="form-check-label" for="allergicYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="allergic" id="allergicNo" value="No" required>
                    <label class="form-check-label" for="allergicNo">No</label>
                  </div>
                </div>
                <!-- Care responsibility -->
                <div class="col-12">
                  <label for="careResponsibility" class="form-label">Who will be responsible for feeding, grooming, and generally caring for your pet?*</label>
                  <input type="text" class="form-control" id="careResponsibility" name="careResponsibility" required>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <!-- Financial responsibility -->
                <div class="col-12">
                  <label for="financialResponsibility" class="form-label">Who will be financially responsible for your pet’s needs (i.e. food, vet bills, etc.)?*</label>
                  <input type="text" class="form-control" id="financialResponsibility" name="financialResponsibility" required>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <!-- Vacation care -->
                <div class="col-12">
                  <label for="vacationCare" class="form-label">Who will look after your pet if you go on vacation or in case of emergency?*</label>
                  <input type="text" class="form-control" id="vacationCare" name="vacationCare" required>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <!-- Hours alone -->
                <div class="col-12">
                  <label for="hoursAlone" class="form-label">How many hours in an average workday will your pet be left alone?*</label>
                  <input type="number" class="form-control" id="hoursAlone" name="hoursAlone" required>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <!-- Introduction steps -->
                <div class="col-12">
                  <label for="introductionSteps" class="form-label">What steps will you take to introduce your new pet to his/her new surroundings?*</label>
                  <textarea class="form-control" id="introductionSteps" name="introductionSteps" rows="3" required></textarea>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <!-- Family support -->
                <div class="col-12">
                  <label class="form-label">Does everyone in the family support your decision to adopt a pet?*</label>
                  <br>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="familySupport" id="familySupportYes" value="Yes" required>
                    <label class="form-check-label" for="familySupportYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="familySupport" id="familySupportNo" value="No" required>
                    <label class="form-check-label" for="familySupportNo">No</label>
                  </div>
                </div>
                <!-- Support explanation -->
                <div class="col-12">
                  <label for="supportExplanation" class="form-label">Please explain*</label>
                  <textarea class="form-control" id="supportExplanation" name="supportExplanation" rows="3" required></textarea>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <!-- Other pets -->
                <div class="col-12">
                  <label class="form-label">Do you have other pets?*</label>
                  <br>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="otherPets" id="otherPetsYes" value="Yes" required>
                    <label class="form-check-label" for="otherPetsYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="otherPets" id="otherPetsNo" value="No" required>
                    <label class="form-check-label" for="otherPetsNo">No</label>
                  </div>
                </div>
                <!-- Past pets -->
                <div class="col-12">
                  <label class="form-label">Have you had pets in the past?*</label>
                  <br>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="pastPets" id="pastPetsYes" value="Yes" required>
                    <label class="form-check-label" for="pastPetsYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="pastPets" id="pastPetsNo" value="No" required>
                    <label class="form-check-label" for="pastPetsNo">No</label>
                  </div>
                </div>
              </div>
              <!-- End Section 3 -->

              <!-- Section 4: Attachments & Interview -->
              <hr class="my-4">
                <!-- Home photos -->
                <div class="col-12">
                  <label for="homePhotos" class="form-label">Please attach photos of your home. This has replaced our on-site ocular inspections.*</label>
                  <input type="file" class="form-control" id="homePhotos" name="homePhotos[]" multiple required>
                  <div class="form-text">Max. file size: 8 MB per file.</div>
                </div>
                <!-- Valid ID -->
                <div class="col-12">
                  <label for="validID" class="form-label">Upload a valid ID*</label>
                  <input type="file" class="form-control" id="validID" name="validID" required>
                  <div class="form-text">Max. file size: 8 MB.</div>
                </div>

          <div class="modal-footer mt-4">
            <button type="submit" class="btn btn-primary">Submit Application</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Adoption Request Modal -->
<div class="modal fade" id="adoptModal" tabindex="-1" aria-labelledby="adoptModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content shadow-sm rounded">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="adoptModalLabel">Adoption Application</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="background: #f9f9f9;">
        <form id="adoptionForm" action="submit_adoption.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
          <div class="row">
            <!-- Left Column: Pet Information -->
            <div class="col-md-4 border-end">
              <div class="text-center mb-3">
                <img id="modal-pet-image" src="" alt="Pet Image" class="img-fluid rounded" style="max-height: 200px;">
              </div>
              <h6 class="text-center" id="modal-pet-name"></h6>
              <p class="text-center"><strong>Breed:</strong> <span id="modal-pet-breed"></span></p>
              <p id="modal-pet-info"></p>
              <p><strong>Owner Email:</strong> <span id="modal-owner-email"></span></p>
              <!-- Hidden fields for pet info -->
              <input type="hidden" id="modal-pet-id" name="pet_id">
              <input type="hidden" id="modal-owner-email-hidden" name="owner_email">
            </div>

            <!-- Right Column: Applicant Information -->
            <div class="col-md-8">
              <!-- Section 1: Personal Information -->
              <div class="section-title">Personal Information</div>
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="firstName" class="form-label">First Name*</label>
                  <input type="text" class="form-control" id="firstName" name="firstName" required>
                  <div class="invalid-feedback">First name is required.</div>
                </div>
                <div class="col-md-6">
                  <label for="lastName" class="form-label">Last Name*</label>
                  <input type="text" class="form-control" id="lastName" name="lastName" required>
                  <div class="invalid-feedback">Last name is required.</div>
                </div>
                <div class="col-12">
                  <label for="address" class="form-label">Address*</label>
                  <input type="text" class="form-control" id="address" name="address" required>
                  <div class="invalid-feedback">Address is required.</div>
                </div>
                <div class="col-md-6">
                  <label for="phone" class="form-label">Phone*</label>
                  <input type="tel" class="form-control" id="phone" name="phone" required>
                  <div class="invalid-feedback">Phone is required.</div>
                </div>
                <div class="col-md-6">
                  <label for="email" class="form-label">Email*</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                  <div class="invalid-feedback">Email is required.</div>
                </div>
                <div class="col-md-6">
                  <label for="birthDate" class="form-label">Birth Date*</label>
                  <input type="date" class="form-control" id="birthDate" name="birthDate" required>
                  <div class="invalid-feedback">Birth date is required.</div>
                </div>
                <div class="col-md-6">
                  <label for="occupation" class="form-label">Occupation</label>
                  <input type="text" class="form-control" id="occupation" name="occupation">
                </div>
                <div class="col-12">
                  <label for="companyName" class="form-label">Company/Business Name*</label>
                  <input type="text" class="form-control" id="companyName" name="companyName" placeholder="Please type N/A if unemployed" required>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <div class="col-12">
                  <label for="socialMedia" class="form-label">Social Media Profile</label>
                  <input type="url" class="form-control" id="socialMedia" name="socialMedia" placeholder="Please type N/A if no social media; Enter FB/Twitter/IG Link">
                </div>
                <div class="col-12">
                  <label class="form-label">Status*</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="statusSingle" value="Single" required>
                    <label class="form-check-label" for="statusSingle">Single</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="statusMarried" value="Married" required>
                    <label class="form-check-label" for="statusMarried">Married</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="statusOthers" value="Others" required>
                    <label class="form-check-label" for="statusOthers">Others</label>
                  </div>
                </div>
                <div class="col-12">
                  <label class="form-label">Pronouns*</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="pronouns" id="pronounsShe" value="She/her" required>
                    <label class="form-check-label" for="pronounsShe">She/her</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="pronouns" id="pronounsHe" value="He/him" required>
                    <label class="form-check-label" for="pronounsHe">He/him</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="pronouns" id="pronounsThey" value="They/them" required>
                    <label class="form-check-label" for="pronounsThey">They/them</label>
                  </div>
                </div>
                <div class="col-12">
                  <label class="form-label">What prompted you to adopt from PAWS?*</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="prompted" id="promptedFriends" value="Friends" required>
                    <label class="form-check-label" for="promptedFriends">Friends</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="prompted" id="promptedWebsite" value="Website" required>
                    <label class="form-check-label" for="promptedWebsite">Website</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="prompted" id="promptedSocialMedia" value="Social Media" required>
                    <label class="form-check-label" for="promptedSocialMedia">Social Media</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="prompted" id="promptedOther" value="Other" required>
                    <label class="form-check-label" for="promptedOther">Other</label>
                  </div>
                </div>
                <div class="col-12">
                  <label class="form-label">Have you adopted from PAWS before?*</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="adoptedBefore" id="adoptedBeforeYes" value="Yes" required>
                    <label class="form-check-label" for="adoptedBeforeYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="adoptedBefore" id="adoptedBeforeNo" value="No" required>
                    <label class="form-check-label" for="adoptedBeforeNo">No</label>
                  </div>
                </div>
              </div>

              <!-- Section 2: Alternate Contact -->
              <hr class="my-4">
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="altFirstName" class="form-label">First Name*</label>
                  <input type="text" class="form-control" id="altFirstName" name="altFirstName" required>
                  <div class="invalid-feedback">Alternate contact first name is required.</div>
                </div>
                <div class="col-md-6">
                  <label for="altLastName" class="form-label">Last Name*</label>
                  <input type="text" class="form-control" id="altLastName" name="altLastName" required>
                  <div class="invalid-feedback">Alternate contact last name is required.</div>
                </div>
                <div class="col-12">
                  <small class="text-muted">If the applicant is a minor, a parent or guardian must be the alternate contact and co-sign the application.</small>
                </div>
                <div class="col-12">
                  <label for="relationship" class="form-label">Relationship*</label>
                  <input type="text" class="form-control" id="relationship" name="relationship" required>
                  <div class="invalid-feedback">Relationship is required.</div>
                </div>
                <div class="col-md-6">
                  <label for="altPhone" class="form-label">Phone*</label>
                  <input type="tel" class="form-control" id="altPhone" name="altPhone" required>
                  <div class="invalid-feedback">Alternate contact phone is required.</div>
                </div>
                <div class="col-md-6">
                  <label for="altEmail" class="form-label">Email*</label>
                  <input type="email" class="form-control" id="altEmail" name="altEmail" required>
                  <div class="invalid-feedback">Alternate contact email is required.</div>
                </div>
              </div>

              <!-- Section 3: Questionnaire -->
              <hr class="my-4">
              <div class="section-title">Questionnaire</div>
              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label">What are you looking to adopt?*</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="lookingToAdopt" id="adoptCat" value="Cat" required>
                    <label class="form-check-label" for="adoptCat">Cat</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="lookingToAdopt" id="adoptDog" value="Dog" required>
                    <label class="form-check-label" for="adoptDog">Dog</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="lookingToAdopt" id="adoptBoth" value="Both" required>
                    <label class="form-check-label" for="adoptBoth">Both</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="lookingToAdopt" id="adoptNotDecided" value="Not Decided" required>
                    <label class="form-check-label" for="adoptNotDecided">Not decided</label>
                  </div>
                </div>
                <div class="col-12">
                  <label class="form-label">Are you applying to adopt a specific shelter animal?*</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="specificAnimal" id="specificAnimalYes" value="Yes" required>
                    <label class="form-check-label" for="specificAnimalYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="specificAnimal" id="specificAnimalNo" value="No" required>
                    <label class="form-check-label" for="specificAnimalNo">No</label>
                  </div>
                </div>
                <div class="col-12">
                  <label for="idealPetDescription" class="form-label">Describe your ideal pet, including its sex, age, appearance, temperament, etc.*</label>
                  <textarea class="form-control" id="idealPetDescription" name="idealPetDescription" rows="3" required></textarea>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <div class="col-12">
                  <label class="form-label">What type of building do you live in?*</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="buildingType" id="buildingHouse" value="House" required>
                    <label class="form-check-label" for="buildingHouse">House</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="buildingType" id="buildingApartment" value="Apartment" required>
                    <label class="form-check-label" for="buildingApartment">Apartment</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="buildingType" id="buildingCondo" value="Condo" required>
                    <label class="form-check-label" for="buildingCondo">Condo</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="buildingType" id="buildingOther" value="Other" required>
                    <label class="form-check-label" for="buildingOther">Other</label>
                  </div>
                </div>
                <div class="col-12">
                  <label class="form-label">Do you rent?*</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rent" id="rentYes" value="Yes" required>
                    <label class="form-check-label" for="rentYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rent" id="rentNo" value="No" required>
                    <label class="form-check-label" for="rentNo">No</label>
                  </div>
                </div>
                <div class="col-12">
                  <label for="petWhenMove" class="form-label">What happens to your pet if or when you move?*</label>
                  <input type="text" class="form-control" id="petWhenMove" name="petWhenMove" required>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <div class="col-12">
                  <label class="form-label">Who do you live with?*</label>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="liveWith[]" id="liveAlone" value="Living alone">
                    <label class="form-check-label" for="liveAlone">Living alone</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="liveWith[]" id="liveSpouse" value="Spouse">
                    <label class="form-check-label" for="liveSpouse">Spouse</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="liveWith[]" id="liveParents" value="Parents">
                    <label class="form-check-label" for="liveParents">Parents</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="liveWith[]" id="liveChildrenOver" value="Children over 18">
                    <label class="form-check-label" for="liveChildrenOver">Children over 18</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="liveWith[]" id="liveChildrenBelow" value="Children below 18">
                    <label class="form-check-label" for="liveChildrenBelow">Children below 18</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="liveWith[]" id="liveRelatives" value="Relatives">
                    <label class="form-check-label" for="liveRelatives">Relatives</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="liveWith[]" id="liveRoommate" value="Roommate(s)">
                    <label class="form-check-label" for="liveRoommate">Roommate(s)</label>
                  </div>
                </div>
                <div class="col-12">
                  <label class="form-label">Are any members of your household allergic to animals?*</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="allergic" id="allergicYes" value="Yes" required>
                    <label class="form-check-label" for="allergicYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="allergic" id="allergicNo" value="No" required>
                    <label class="form-check-label" for="allergicNo">No</label>
                  </div>
                </div>
                <div class="col-12">
                  <label for="careResponsibility" class="form-label">Who will be responsible for feeding, grooming, and generally caring for your pet?*</label>
                  <input type="text" class="form-control" id="careResponsibility" name="careResponsibility" required>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <div class="col-12">
                  <label for="financialResponsibility" class="form-label">Who will be financially responsible for your pet’s needs (i.e. food, vet bills, etc.)?*</label>
                  <input type="text" class="form-control" id="financialResponsibility" name="financialResponsibility" required>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <div class="col-12">
                  <label for="vacationCare" class="form-label">Who will look after your pet if you go on vacation or in case of emergency?*</label>
                  <input type="text" class="form-control" id="vacationCare" name="vacationCare" required>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <div class="col-12">
                  <label for="hoursAlone" class="form-label">How many hours in an average workday will your pet be left alone?*</label>
                  <input type="number" class="form-control" id="hoursAlone" name="hoursAlone" required>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <div class="col-12">
                  <label for="introductionSteps" class="form-label">What steps will you take to introduce your new pet to his/her new surroundings?*</label>
                  <textarea class="form-control" id="introductionSteps" name="introductionSteps" rows="3" required></textarea>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <div class="col-12">
                  <label class="form-label">Does everyone in the family support your decision to adopt a pet?*</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="familySupport" id="familySupportYes" value="Yes" required>
                    <label class="form-check-label" for="familySupportYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="familySupport" id="familySupportNo" value="No" required>
                    <label class="form-check-label" for="familySupportNo">No</label>
                  </div>
                </div>
                <div class="col-12">
                  <label for="supportExplanation" class="form-label">Please explain*</label>
                  <textarea class="form-control" id="supportExplanation" name="supportExplanation" rows="3" required></textarea>
                  <div class="invalid-feedback">This field is required.</div>
                </div>
                <div class="col-12">
                  <label class="form-label">Do you have other pets?*</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="otherPets" id="otherPetsYes" value="Yes" required>
                    <label class="form-check-label" for="otherPetsYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="otherPets" id="otherPetsNo" value="No" required>
                    <label class="form-check-label" for="otherPetsNo">No</label>
                  </div>
                </div>
                <div class="col-12">
                  <label class="form-label">Have you had pets in the past?*</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="pastPets" id="pastPetsYes" value="Yes" required>
                    <label class="form-check-label" for="pastPetsYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="pastPets" id="pastPetsNo" value="No" required>
                    <label class="form-check-label" for="pastPetsNo">No</label>
                  </div>
                </div>
              </div>

          <div class="modal-footer mt-4">
            <button type="submit" class="btn btn-primary">Submit Application</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>