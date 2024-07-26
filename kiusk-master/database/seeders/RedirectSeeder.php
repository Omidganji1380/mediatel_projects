<?php

namespace Database\Seeders;

use App\Models\Ad\Ad;
use App\Models\Ad\Category;
use App\Models\Blog\Post;
use App\Models\Redirect;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RedirectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $redirects = Redirect::take(10)->orderByDesc('created_at')->get();

        $oldLinks = [
            "https://kiusk.ca/weblog-2",
            "https://kiusk.ca/product-category/%D9%85%D8%B4%D8%A7%D9%88%D8%B1%D9%87/",
            "https://kiusk.ca/product-category/%D8%AE%D8%AF%D9%85%D8%A7%D8%AA-%D9%85%D9%87%D8%A7%D8%AC%D8%B1%D8%AA%DB%8C/",
            "https://kiusk.ca/product-category/%D9%88%DA%A9%DB%8C%D9%84-%D9%88-%D8%AE%D8%AF%D9%85%D8%A7%D8%AA-%D8%AD%D9%82%D9%88%D9%82%DB%8C/",
            "https://kiusk.ca/product-category/%D8%A7%D9%86%D8%AC%D8%A7%D9%85-%D8%A7%D9%85%D9%88%D8%B1-%D8%AE%D8%B1%DB%8C%D8%AF-%D9%88-%D9%81%D8%B1%D9%88%D8%B4-%D9%88-%D8%A7%D8%AC%D8%A7%D8%B1%D9%87/",
            "https://kiusk.ca/ads/%D8%B4%D8%B1%DA%A9%D8%AA-%D8%A2%D8%AA%DB%8C-%DA%AF%D8%B1%D9%88%D9%BE-%D8%AA%D9%88%D8%B1%D9%86%D8%AA%D9%88/",
            "https://kiusk.ca/ads/%D9%86%DB%8C%D9%84%D9%88%D9%81%D8%B1-%D8%A8%D8%A7%D9%82%D8%B1%D8%B2%D8%A7%D8%AF%D9%87%D8%8C-%DA%A9%D8%A7%D8%B1%D8%B4%D9%86%D8%A7%D8%B3-%D8%B1%D8%B3%D9%85%DB%8C-%D9%85%D9%87%D8%A7%D8%AC%D8%B1%D8%AA/",
            "https://kiusk.ca/ads/%D8%A7%D8%AE%D8%B0-%D9%88%DB%8C%D8%B2%D8%A7%DB%8C-%D8%AA%D8%AD%D8%B5%DB%8C%D9%84%DB%8C/",
            "https://kiusk.ca/product-category/%D8%AA%D8%AF%D8%B1%DB%8C%D8%B3-%D8%AE%D8%B5%D9%88%D8%B5%DB%8C/",
            "https://kiusk.ca/product-category/%D8%AD%D8%B3%D8%A7%D8%A8%D8%AF%D8%A7%D8%B1%DB%8C/",
            "https://kiusk.ca/product-category/%D8%AE%D8%AF%D9%85%D8%A7%D8%AA-%D8%B2%DB%8C%D8%A8%D8%A7%DB%8C%DB%8C/",
            "https://kiusk.ca/%D8%A7%D8%AE%D8%A8%D8%A7%D8%B1/",
            "https://kiusk.ca/product-category/%D9%82%D9%86%D8%A7%D8%AF%DB%8C/",
            "https://kiusk.ca/product-category/%D9%82%D8%A7%D9%84%DB%8C-%D8%B4%D9%88%DB%8C%DB%8C/",
            "https://kiusk.ca/product-category/%D9%BE%D8%B2%D8%B4%DA%A9/",
            "https://kiusk.ca/product-category/%D8%B5%D8%B1%D8%A7%D9%81%DB%8C/",
            "https://kiusk.ca/product-category/%DA%AF%D8%B1%D8%A7%D9%81%DB%8C%DA%A9/",
            "https://kiusk.ca/product-category/%D9%85%D8%AF%D8%B1%D8%B3%D9%87/",
            "https://kiusk.ca/product-category/%D8%AF%D9%88%D8%B1%D9%87-%D9%87%D8%A7%DB%8C-%D8%AA%D8%AE%D8%B5%D8%B5%DB%8C/",
            "https://kiusk.ca/product-category/sell-buisness/",
            "https://kiusk.ca/blog/1400/05/06/pearson-airport-will-not-segregate-passengers/",
            "https://kiusk.ca/blog/2021/09/05/the-covid-19-vaccine-is-not-dangerous-for-people-with-allergies/",
            "https://kiusk.ca/blog/1399/11/08/%D8%B1%D8%A7%D9%87-%D8%A7%D9%86%D8%AF%D8%A7%D8%B2%D9%8A-%D9%88-%D8%AA%D8%A7%D8%B3%D9%8A%D8%B3-%D8%B1%D8%B3%D8%AA%D9%88%D8%B1%D8%A7%D9%86-%D8%AF%D8%B1-%D9%83%D8%A7%D9%86%D8%A7%D8%AF%D8%A7/",
            "https://kiusk.ca/blog/1400/08/02/scientists-have-found-the-scariest-new-movie-of-all-time/",
            "https://kiusk.ca/blog/1400/06/31/renting-a-house-or-buying-a-house-in-canada-which-is-better/",
            "https://kiusk.ca/blog/1400/05/05/overdose-cases-last-6-months-than-all-previous-year-cases/",
            "https://kiusk.ca/blog/1400/04/12/canada-is-targeting-higher-vaccination-rates-to-reduce-border-restrictions/",
            "https://kiusk.ca/blog/1400/06/07/the-taliban-sealed-kabul-airport/",
            "https://kiusk.ca/blog/1400/04/19/what-is-it-like-to-study-law-in-canada/",
            "https://kiusk.ca/blog/1400/07/14/terms-and-benefits-of-canada-provincial-immigration-service-and-program/",
            "https://kiusk.ca/blog/2021/09/09/alberta-aha-protests-alcohol-restrictions/",
            "https://kiusk.ca/blog/1400/06/16/very-low-sensitivity-of-delta-variants-to-neutralizing-antibodies/",
            "https://kiusk.ca/blog/1400/08/04/writing-a-resume-for-a-job-in-canada/",
            "https://kiusk.ca/blog/1400/05/09/canada-moves-to-the-fourth-wave/",
            "https://kiusk.ca/blog/1400/06/05/suskton-is-involved-in-an-epidemic-of-increasing-syphilis/",
            "https://kiusk.ca/ads/polabox-%D8%B7%D8%B9%D9%85-%D8%A7%D8%B5%DB%8C%D9%84-%D8%BA%D8%B0%D8%A7%DB%8C-%D8%A7%DB%8C%D8%B1%D8%A7%D9%86%DB%8C/",
            "https://kiusk.ca/blog/1400/05/07/admission-of-35000-immigrants-in-june/",
            "https://kiusk.ca/ads/%D8%BA%D8%B0%D8%A7%DB%8C-%D8%A8%D9%8A%D8%B1%D9%88%D9%86-%D8%A8%D8%B1-%D8%AE%D8%A7%D9%86%DA%AF%D9%8A-%D8%AC%D9%86%D9%88%D8%A8%D9%8A-%D9%84%D9%8A%D8%A7%D9%86/",
            "https://kiusk.ca/blog/1400/06/12/western-union-resumes-private-remittances-to-afghanistan/",
            "https://kiusk.ca/blog/1400/06/24/the-close-competition-of-the-leading-federal-parties/",
            "https://kiusk.ca/blog/1400/07/05/negative-impact-of-covid-19-restrictions-on-local-restaurants/",
            "https://kiusk.ca/blog/2021/08/03/what-is-a-multiple-canada-visa-its-terms/",
            "https://kiusk.ca/blog/1400/05/09/publication-of-details-of-the-removal-of-anteroids/",
            "https://kiusk.ca/blog/1400/11/27/unemployment-insurance",
            "https://kiusk.ca/blog/2021/07/31/everything-about-industrial-design-in-canada-a-money-making-and-popular-field/",
            "https://kiusk.ca/blog/1400/04/17/canadian-researchers-find-out-how-blood-clots-form-after-injection-of-astrazenka-vaccine/",
            "https://kiusk.ca/blog/1400/05/04/increasing-number-of-patients-with-covid-19-and-delta-variant-in-boss/",
            "https://kiusk.ca/blog/2021/08/30/canada-talks-with-taliban-to-repatriate-canadian-citizens-to-afghanistan/",
            "https://kiusk.ca/product-category/%D8%AE%D8%AF%D9%85%D8%A7%D8%AA-%D8%B3%D8%A7%D8%AE%D8%AA%D9%85%D8%A7%D9%86%DB%8C/",
            "https://kiusk.ca/blog/2021/09/02/the-liberals-announced-their-campaign-platform/",
            "https://kiusk.ca/blog/1400/06/05/alberta-increased-liver-disease-in-the-covid-19-pandemic/",
            "https://kiusk.ca/blog/2021/07/10/student-work-in-canada-and-its-conditions/",
            "https://kiusk.ca/blog/1400/06/25/canadas-highest-paid-jobs-that-do-not-require-a-degree/",
            "https://kiusk.ca/ads/alfa-design-%D8%A8%D8%A7%D8%B2%D8%B3%D8%A7%D8%B2%DB%8C-%D9%88-%D9%86%D9%88%D8%B3%D8%A7%D8%B2%DB%8C-%D8%AE%D8%A7%D9%86%D9%87/",
            "https://kiusk.ca/ads/rr-towing-service-%D8%AE%D8%AF%D9%85%D8%A7%D8%AA-%D8%AD%D9%85%D9%84-%D8%A7%D8%AA%D9%88%D9%85%D8%A8%DB%8C%D9%84/",
            "https://kiusk.ca/blog/1400/06/08/covid-19-compulsory-vaccination-policy-in-ottawa/",
            "https://kiusk.ca/blog/1399/12/23/%D8%A8%DB%8C%D9%85%D9%87-%D8%AE%D8%AF%D9%85%D8%A7%D8%AA-%D8%AF%D8%B1%D9%85%D8%A7%D9%86%DB%8C-%D8%AF%D8%B1-%DA%A9%D8%A7%D9%86%D8%A7%D8%AF%D8%A7/",
            "https://kiusk.ca/blog/1400/05/11/there-were-no-coronary-patients-in-ottawa-hospitals-on-sunday/",
            "https://kiusk.ca/blog/1400/04/25/public-health-in-canada-and-its-various-provinces/",
            "https://kiusk.ca/blog/2021/08/30/opposition-to-compulsory-vaccination-in-canada/",
            "https://kiusk.ca/product-category/%D8%A8%DB%8C%D9%85%D9%87/",
            "https://kiusk.ca/blog/2022/02/14/setting-up-an-exchange-office/",
            "https://kiusk.ca/blog/2021/07/13/introduction-to-studying-graphic-design-in-canada/",
            "https://kiusk.ca/ads/minoo-catering-%D9%83%D9%8A%D8%AA%D8%B1%D9%8A%D9%86%DA%AF/",
            "https://kiusk.ca/blog/1400/06/05/requiring-toronto-schools-to-provide-fast-tests/",
            "https://kiusk.ca/blog/1400/06/11/the-liberals-announced-their-campaign-platform/",
            "https://kiusk.ca/blog/2021/08/26/execute-the-command-to-use-the-mask-indoors-in-the-bbc/",
            "https://kiusk.ca/blog/1400/06/09/about-700-new-corona-cases-in-antero/",
            "https://kiusk.ca/product-category/%D8%B3%D8%A7%DB%8C%D8%B1-%D9%85%D8%B4%D8%A7%D8%BA%D9%84/",
            "https://kiusk.ca/blog/1400/05/09/introducing-the-university-of-ottawa-canadas-top-university/",
            "https://kiusk.ca/blog/1400/06/19/staying-after-studying-in-canada/",
            "https://kiusk.ca/blog/2021/08/26/in-quebec-it-is-possible-to-download-the-vaccine-passport-application-from-wednesday/",
            "https://kiusk.ca/blog/1400/04/12/the-kennedys-an-ice-hockey-team-believe-that-there-is-a-long-way-to-go-before-the-stanley-cup-final/",
            "https://kiusk.ca/blog/2021/08/22/renting-a-house-in-canada-is-the-most-important-step-for-any-immigrant/",
            "https://kiusk.ca/blog/1400/06/06/a-magnitude-3-8-earthquake-shook-western-quebec/",
            "https://kiusk.ca/blog/1400/05/06/canadas-most-lovely-places-for-kids/",
            "https://kiusk.ca/blog/1400/05/12/it-is-too-early-to-remove-the-masks/",
            "https://kiusk.ca/blog/1400/05/01/the-aurora-borealis-phenomenon-in-canada-the-most-beautiful-celestial-phenomenon-in-this-country/",
            "https://kiusk.ca/blog/1400/06/08/ways-to-get-vaccinated-in-canada/",
            "https://kiusk.ca/blog/2021/08/30/the-liberals-promise-to-regulate-emissions-from-the-oil-and-gas-sector/",
            "https://kiusk.ca/ads/toronto-freight-%D8%AD%D9%85%D9%84-%D9%88-%D9%86%D9%82%D9%84-%D8%A8%DB%8C%D9%86-%D8%A7%D9%84%D9%85%D9%84%D9%84%DB%8C/",
            "https://kiusk.ca/blog/1400/07/18/canada-disgruntled-association-of-restaurants/",
            "https://kiusk.ca/blog/1400/04/31/get-to-know-the-national-symbols-of-canada-what-is-canada-famous-for/",
            "https://kiusk.ca/blog/2022/01/10/buying-a-business-in-canada/",
            "https://kiusk.ca/blog/1400/07/19/canada-parents-of-students-students-and-doctors-apply-for-vaccination-of-children/",
            "https://kiusk.ca/blog/1400/05/10/university-of-ottawa-history-and-university-building-fire/",
            "https://kiusk.ca/blog/2022/01/09/buy-a-car-in-canada/",
            "https://kiusk.ca/blog/1400/04/17/about-the-yukon-in-canada-a-pristine-province-for-adventure/",
            "https://kiusk.ca/blog/1400/06/19/the-best-toronto-neighborhoods-to-buy-a-home/",
            "https://kiusk.ca/product-category/%D8%B3%D9%88%D9%BE%D8%B1-%D9%85%D8%A7%D8%B1%DA%A9%D8%AA-%D9%88-%D9%85%D9%88%D8%A7%D8%AF-%D8%BA%D8%B0%D8%A7%DB%8C%DB%8C/",
            "https://kiusk.ca/ads/b-m-marketing-inc-%D8%AD%D9%85%D9%84-%D8%A8%D8%A7%D8%B1/",
            "https://kiusk.ca/product-category/%D8%B1%D8%B3%D8%AA%D9%88%D8%B1%D8%A7%D9%86-%D8%A8%D8%AF%D9%88%D9%86-%D8%AF%D8%B3%D8%AA%D9%87%E2%80%8C%D8%A8%D9%86%D8%AF%DB%8C/",
            "https://kiusk.ca/blog/1400/07/29/announcement-of-canada-plans-for-an-international-vaccine-passport/",
            "https://kiusk.ca/blog/1400/06/21/canada-calls-on-party-leaders-to-fight-racial-discrimination/",
            "https://kiusk.ca/blog/2022/01/05/rent-a-house-in-saskatchewan/",
            "https://kiusk.ca/product-category/bag-shoe-dress/",
            "https://kiusk.ca/blog/1400/06/18/two-residents-of-an-oshawa-nursing-home-die-due-to-a-corona-outbreak/",
            "https://kiusk.ca/blog/1400/06/04/compulsory-vaccination-for-toronto-police-officers/",
            "https://kiusk.ca/blog/2021/01/27/%D8%B1%D8%A7%D9%87-%D8%A7%D9%86%D8%AF%D8%A7%D8%B2%D9%8A-%D9%88-%D8%AA%D8%A7%D8%B3%D9%8A%D8%B3-%D8%B1%D8%B3%D8%AA%D9%88%D8%B1%D8%A7%D9%86-%D8%AF%D8%B1-%D9%83%D8%A7%D9%86%D8%A7%D8%AF%D8%A7/",
            "https://kiusk.ca/blog/1400/05/12/shooting-in-the-town-of-clooney-and-two-people-injured/",
            "https://kiusk.ca/blog/1400/05/11/affected-by-recent-events-rename-the-field-in-edmonton/",
            "https://kiusk.ca/blog/1400/04/28/important-points-from-the-university-of-british-columbia-that-you-did-not-know/",
            "https://kiusk.ca/blog/1400/06/18/all-translated-documents-are-required-to-immigrate-to-canada/",
            "https://kiusk.ca/blog/1400/06/26/due-to-the-increase-in-cases-the-patients-were-transferred-from-alberta-to-antrio/",
            "https://kiusk.ca/blog/1400/07/06/the-best-student-cities-in-canada/",
            "https://kiusk.ca/ads/ava-window-fashions-%D9%88%DB%8C%D9%86%D8%AF%D9%88-%D8%B4%D8%A7%D8%AA%D8%B1/",
            "https://kiusk.ca/blog/2021/09/10/first-day-of-school-for-parents-of-toronto-students/",
            "https://kiusk.ca/blog/1400/04/16/manitoba-canadas-tourist-attractions/",
            "https://kiusk.ca/blog/1400/08/01/vaccination-of-toronto-zoo-animals-against-covid-19/",
            "https://kiusk.ca/blog/1400/08/07/changing-facebooks-name-does-not-take-it-out-of-the-crisis/",
            "https://kiusk.ca/blog/1400/04/17/a-man-convicted-in-british-columbia-of-murdering-a-teenager/",
            "https://kiusk.ca/blog/1400/05/07/you-made-lucrative-jobs-in-canada-that-you-dont-even-think-about/",
            "https://kiusk.ca/blog/1400/06/05/alberta-oil-company-employees-should-be-vaccinated/",
            "https://kiusk.ca/blog/1400/04/26/what-is-the-banking-market-like-in-canada/",
            "https://kiusk.ca/blog/2021/09/09/two-residents-of-an-oshawa-nursing-home-die-due-to-a-corona-outbreak/",
            "https://kiusk.ca/ads/global-united-shipping-inc-%D8%AD%D9%85%D9%84-%D9%88-%D9%86%D9%82%D9%84/",
            "https://kiusk.ca/blog/1400/06/14/hiring-contract-nurses-due-to-staff-shortages-in-alberta/",
            "https://kiusk.ca/blog/1400/07/28/saskatchewan-requests-early-assistance-from-the-united-states/",
            "https://kiusk.ca/blog/1400/06/19/the-last-debate-of-the-candidate-of-the-federal-parties-was-held/",
            "https://kiusk.ca/blog/1400/04/24/how-well-do-you-know-the-university-of-toronto/",
            "https://kiusk.ca/blog/1400/08/09/3-killed-in-widespread-protests-against-sudans-coup/",
            "https://kiusk.ca/blog/1400/04/14/the-gradual-return-of-quebec-citizens-to-work/",
            "https://kiusk.ca/blog/1400/12/4/setting-up-a-supermarket-in-canada",
            "https://kiusk.ca/blog/1400/04/18/what-is-it-like-to-study-painting-in-canada/",
            "https://kiusk.ca/ads/art-moving-and-storage-%D8%A7%D8%B3%D8%A8%D8%A7%D8%A8-%DA%A9%D8%B4%DB%8C-%D9%88-%D9%85%D9%88%D9%88%DB%8C%D9%86%DA%AF/",
            "https://kiusk.ca/blog/1400/06/02/vaccination-certificate-is-required-at-td-place-stadium/",
            "https://kiusk.ca/blog/2021/07/26/interruption-in-the-rapid-growth-of-fires-in-bessie/",
            "https://kiusk.ca/ads/aqua-milano-%D8%B4%DB%8C%D8%B1%D8%A2%D9%84%D8%A7%D8%AA-%D9%84%D9%88%DA%A9%D8%B3-%D8%B3%D8%A7%D8%AE%D8%AA%D9%85%D8%A7%D9%86%DB%8C/",
            "https://kiusk.ca/blog/1400/05/11/provincial-immigration-programs-canada-ontario/",
            "https://kiusk.ca/product-category/%D8%A7%D9%85%D9%88%D8%B1-%D9%88%D8%A7%D9%85/",
            "https://kiusk.ca/blog/1400/06/23/canadian-travel-health-insurance/",
            "https://kiusk.ca/blog/1400/07/23/increasing-number-of-students-in-japanese-schools-for-suicide/",
            "https://kiusk.ca/blog/1400/04/30/hospitality-in-canada-and-its-conditions/",
            "https://kiusk.ca/blog/1400/06/23/british-columbia-compulsory-vaccination-to-all-health-centers/",
            "https://kiusk.ca/blog/1400/06/16/withdrawal-of-canadian-armed-forces-from-bossi/",
            "https://kiusk.ca/blog/1400/06/07/increase-in-covid-19-hospitalization-in-ottawa/",
            "https://kiusk.ca/blog/1400/07/10/send-the-preliminary-results-of-the-pfizer-vaccine-to-canada-health/",
            "https://kiusk.ca/blog/1400/08/03/job-search-in-ottawa-canada-job-list-and-salary/",
            "https://kiusk.ca/blog/1399/09/07/%DA%86%DA%AF%D9%88%D9%86%D9%87-%D8%AF%D8%B1-%D8%A7%DB%8C%D9%86%D8%AA%D8%B1%D9%86%D8%AA-%D8%AF%D9%86%D8%A8%D8%A7%D9%84-%D8%AE%D8%A7%D9%86%D9%87-%D8%A8%DA%AF%D8%B1%D8%AF%DB%8C%D9%85%D8%9F/https://kiusk.ca/blog/1399/09/07/%DA%86%DA%AF%D9%88%D9%86%D9%87-%D8%AF%D8%B1-%D8%A7%DB%8C%D9%86%D8%AA%D8%B1%D9%86%D8%AA-%D8%AF%D9%86%D8%A8%D8%A7%D9%84-%D8%AE%D8%A7%D9%86%D9%87-%D8%A8%DA%AF%D8%B1%D8%AF%DB%8C%D9%85%D8%9F/",
            "https://kiusk.ca/ads/freight-services-international-%D8%AD%D9%85%D9%84-%D9%88-%D9%86%D9%82%D9%84-%D8%A8%DB%8C%D9%86-%D8%A7%D9%84%D9%85%D9%84%D9%84%DB%8C/",
            "https://kiusk.ca/ads/alfa-design-and-renovation-%D8%A8%D8%A7%D8%B2%D8%B3%D8%A7%D8%B2%DB%8C-%D9%88-%D9%86%D9%88%D8%B3%D8%A7%D8%B2%DB%8C/",
            "https://kiusk.ca/blog/2022/02/06/launch-of-fast-food/",
            "https://kiusk.ca/blog/1400/05/05/saskatoon-city-council-votes-to-release-ashes-from-cremated-river/",
            "https://kiusk.ca/blog/1400/07/04/student-work-in-canada/",
            "https://kiusk.ca/blog/1400/04/20/laboratory-science-in-canada-and-study-conditions/",
            "https://kiusk.ca/blog/2021/09/04/three-quarters-of-canadians-believe-elections-are-not-necessary/",
            "https://kiusk.ca/blog/1400/11/20/fingerprinting-of-the-canadian-embassy",
            "https://kiusk.ca/blog/1400/07/06/things-all-immigrants-need-to-know-about-health-insurance-in-canada/",
            "https://kiusk.ca/blog/1400/06/10/opening-of-covid-19-clinic-for-children-in-2-antrio-hospitals/",
            "https://kiusk.ca/blog/1400/05/06/police-deal-with-a-rally-in-dauphin-county/",
            "https://kiusk.ca/blog/1400/07/27/the-increase-in-investor-income-was-accompanied-by-an-increase-in-asian-stocks/",
            "https://kiusk.ca/blog/1400/05/04/dont-miss-stanley-park-in-vancouver-and-its-stunning-attractions/",
            "https://kiusk.ca/blog/1400/06/06/quebec-612-new-coronary-cases-and-increase-in-the-number-of-beds/",
            "https://kiusk.ca/blog/1400/08/07/all-about-working-in-alberta/",
            "https://kiusk.ca/blog/2021/08/28/quebec-612-new-coronary-cases-and-increase-in-the-number-of-beds/",
            "https://kiusk.ca/blog/2021/09/10/staying-after-studying-in-canada/",
            "https://kiusk.ca/blog/1400/06/29/entrio-police-involvement-in-the-implementation-of-the-policy-of-proof-of-corona-vaccination/",
            "https://kiusk.ca/blog/1400/05/07/discover-three-of-canadas-most-exciting-festivals/",
            "https://kiusk.ca/blog/1400/12/9/car-rental-in-canada",
            "https://kiusk.ca/blog/1400/06/08/brian-palister-resigns-as-manitoba-prime-minister/",
            "https://kiusk.ca/blog/1400/05/08/canadians-strongly-support-immediate-environmental-action/",
            "https://kiusk.ca/blog/1400/04/22/list-of-canadian-universities-that-are-approved-by-the-ministry-of-science/",
            "https://kiusk.ca/blog/1400/05/29/from-zero-to-one-hundred-driving-licenses-in-canada-documents-required-to-obtain-it/",
            "https://kiusk.ca/blog/1400/05/10/extensive-fire-in-turkey-and-evacuation-of-foreign-tourists/",
            "https://kiusk.ca/blog/1400/03/14/%D8%B1%D8%B4%D8%AA%D9%87-%D9%81%DB%8C%D8%B2%DB%8C%D9%88%D8%AA%D8%B1%D8%A7%D9%BE%DB%8C-%D9%88-%D8%AA%D8%AD%D8%B5%DB%8C%D9%84-%D8%A2%D9%86-%D8%AF%D8%B1-%DA%A9%D8%A7%D9%86%D8%A7%D8%AF%D8%A7/",
            "https://kiusk.ca/blog/1400/07/08/the-first-national-day-of-truth-and-reconciliation-in-canada-and-the-different-feelings-of-native-americans-towards-this-day/",
            "https://kiusk.ca/blog/2021/12/20/rent-a-house-in-canada/",
            "https://kiusk.ca/blog/2022/01/03/beauty-salon-in-canada/",
            "https://kiusk.ca/blog/1400/05/07/the-government-of-afghanistan-announced-the-registration-of-yalda-night-in-the-name-of-afghanistan-and-iran-in-unesco/",
            "https://kiusk.ca/blog/1400/06/02/tagged-content-modified-by-justin-trudeau/",
            "https://kiusk.ca/ads/%D8%AC%DA%AF%D8%B1%DA%A9%DB%8C-%D8%A8%D8%A7%D8%BA%DA%86%D9%87/",
            "https://kiusk.ca/blog/2022/01/04/livestock-in-canada/",
            "https://kiusk.ca/blog/1400/06/02/the-winners-of-the-manitoba-vaccination-lottery-are-announced/",
            "https://kiusk.ca/blog/1400/04/14/how-is-health-care-in-canada/",
            "https://kiusk.ca/blog/2022/01/19/poultry-farming-in-canada/",
            "https://kiusk.ca/blog/1400/11/23/launching-a-car-wash-in-canada",
            "https://kiusk.ca/product-category/%D9%85%DA%A9%D8%A7%D9%86%DB%8C%DA%A9/",
            "https://kiusk.ca/blog/1400/07/26/the-death-of-25-year-old-maori-al-black-player-sean-wayne/",
            "https://kiusk.ca/blog/1400/06/13/atoll-and-singh-in-progress-trudeau-remains-the-best-choice-for-prime-minister/",
            "https://kiusk.ca/blog/2021/07/07/34000-vaccinations-for-toronto-residents-this-week/",
            "https://kiusk.ca/blog/1400/07/24/reprimand-ian-stewart-former-president-of-the-public-health-agency-of-canada/",
            "https://kiusk.ca/blog/1400/06/10/reports-of-just-over-500-new-corona-cases-in-entreo/",
            "https://kiusk.ca/blog/2021/09/05/mandatory-mask-orders-in-alberta-schools-are-the-responsibility-of-school-officials/",
            "https://kiusk.ca/blog/1400/04/16/what-you-need-to-know-about-the-canadian-economy/",
            "https://kiusk.ca/blog/1400/04/14/animals-that-are-native-to-canada/",
            "https://kiusk.ca/blog/1400/05/31/a-fireball-was-seen-in-the-sky/",
            "https://kiusk.ca/blog/1400/06/29/common-canadian-housing-market-terms-for-renting-and-buying-a-home/",
            "https://kiusk.ca/product-category/rent-house/",
            "https://kiusk.ca/blog/1400/07/03/corona-rose-in-nursing-homes-across-canada/",
            "https://kiusk.ca/blog/1400/07/27/the-best-ways-to-find-a-job-in-quebec-canada/",
            "https://kiusk.ca/blog/1400/05/08/unvaccinated-people-were-not-allowed-in-cologne/",
            "https://kiusk.ca/blog/2021/09/09/the-first-formal-election-debate-was-held-between-party-leaders/",
            "https://kiusk.ca/blog/1400/05/12/former-primary-school-teacher-pleads-guilty-to-sexual-assault/",
            "https://kiusk.ca/product-category/%D8%B2%DB%8C%D9%88%D8%B1-%D8%A2%D9%84%D8%A7%D8%AA/",
            "https://kiusk.ca/blog/1400/06/08/the-liberals-promise-to-regulate-emissions-from-the-oil-and-gas-sector/",
            "https://kiusk.ca/blog/2021/09/12/canadian-courts-from-zero-to-one-hundred/",
            "https://kiusk.ca/blog/1400/07/11/doctors-request-the-alberta-government-to-release-corona-data/",
            "https://kiusk.ca/blog/1400/06/11/the-fourth-wave-of-the-corona-in-the-anteroom/",
            "https://kiusk.ca/blog/1400/04/31/canadas-snow-attractions-the-best-winter-place-in-the-country/",
            "https://kiusk.ca/product-category/%D8%AD%D9%85%D9%84-%D9%88-%D9%86%D9%82%D9%84/",
            "https://kiusk.ca/blog/1400/06/02/is-it-necessary-to-have-a-vaccine-passport-to-travel-to-canada/",
            "https://kiusk.ca/blog/2022/01/12/gym-club-in-canada/",
            "https://kiusk.ca/blog/1400/06/09/out-of-control-fires-in-the-bbc/",
            "https://kiusk.ca/blog/2021/09/04/vaccination-certification-required-in-ontario/",
            "https://kiusk.ca/product-category/%DA%AF%D9%84%D9%81%D8%B1%D9%88%D8%B4%DB%8C/",
            "https://kiusk.ca/blog/1400/06/04/liberal-leader-asks-for-a-vaccine-passport-meeting/",
            "https://kiusk.ca/blog/2021/07/05/corona-vaccine-off-the-coast-of-british-columbia/",
            "https://kiusk.ca/blog/2021/09/10/the-number-of-new-cases-in-the-anteroom-again-reached-about-800-cases/",
            "https://kiusk.ca/ads/ap-logistics-international-%D8%AD%D9%85%D9%84-%D9%88-%D9%86%D9%82%D9%84-%D8%A8%DB%8C%D9%86-%D8%A7%D9%84%D9%85%D9%84%D9%84%DB%8C/",
            "https://kiusk.ca/ads/%D8%AE%D8%AF%D9%85%D8%A7%D8%AA-%D8%AD%D9%85%D9%84-%D9%88-%D9%86%D9%82%D9%84-%D8%A8%D8%B3%D8%AA%D9%87-%D9%88-%D9%86%D8%A7%D9%85%D9%87-%D9%BE%D8%B3%D8%AA-%D8%A8%D8%B3%D8%AA%D9%87/",
            "https://kiusk.ca/blog/2021/08/27/infection-with-covid-19-after-full-vaccination/",
            "https://kiusk.ca/blog/2021/09/03/western-union-resumes-private-remittances-to-afghanistan/",
            "https://kiusk.ca/blog/1400/06/17/jobs-for-canadian-income-who-do-not-want-you-to-work/",
            "https://kiusk.ca/blog/1400/08/05/36-of-covid-19-cases-occur-in-ontario-public-schools/",
            "https://kiusk.ca/blog/1400/06/16/canada-welcomes-foreign-travelers-by-reopening-its-borders/",
            "https://kiusk.ca/blog/1400/04/27/compare-canadas-ranking-in-educating-children-with-other-countries/",
            "https://kiusk.ca/blog/1399/11/26/%D9%85%D9%87%D8%A7%D8%AC%D8%B1%D8%AA-%D8%BA%D9%88%D8%A7%D8%B5%D8%A7%D9%86-%D8%A8%D9%87-%DA%A9%D8%A7%D9%86%D8%A7%D8%AF%D8%A7/https://kiusk.ca/blog/1399/11/26/%D9%85%D9%87%D8%A7%D8%AC%D8%B1%D8%AA-%D8%BA%D9%88%D8%A7%D8%B5%D8%A7%D9%86-%D8%A8%D9%87-%DA%A9%D8%A7%D9%86%D8%A7%D8%AF%D8%A7/",
            "https://kiusk.ca/blog/2021/09/03/retrieve-wireless-services-in-british-columbia-and-alberta/",
            "https://kiusk.ca/blog/2022/02/16/unemployment-insurance/",
            "https://kiusk.ca/blog/2022/02/12/launching-a-car-wash-in-canada/",
            "https://kiusk.ca/blog/2021/09/07/waterloo-students-return-to-school/",
            "https://kiusk.ca/ads/javid-moving-%D8%A7%D8%B3%D8%A8%D8%A7%D8%A8-%DA%A9%D8%B4%DB%8C-%D9%88-%D9%85%D9%88%D9%88%DB%8C%D9%86%DA%AF/",
            "https://kiusk.ca/blog/1400/04/18/starting-a-number-of-toronto-attractions/",
            "https://kiusk.ca/blog/2021/09/18/home-and-telecommuting-jobs-in-canada/",
            "https://kiusk.ca/ads/%D9%BE%DB%8C%D8%AA%D8%B2%D8%A7-%D9%88-%D8%B3%D8%A7%D9%86%D8%AF%D9%88%DB%8C%DA%86-%D8%B4%D9%85%D8%B4%DA%A9/",
            "https://kiusk.ca/blog/2022/01/01/launching-coffee-shop-canada/",
            "https://kiusk.ca/blog/1400/07/30/federal-officials-announced-the-issuance-of-a-vaccination-certificate-for-the-trip/",
            "https://kiusk.ca/blog/2021/09/05/teacher-shortage-in-nunavut-on-the-eve-of-the-start-of-the-school-year/",
            "https://kiusk.ca/blog/1400/05/31/alberta-health-services-the-medical-staff-is-under-pressure/",
            "https://kiusk.ca/ads/canaan-transport-group-inc-%D8%AD%D9%85%D9%84-%D9%88-%D9%86%D9%82%D9%84-%D8%A8%DB%8C%D9%86-%D8%A7%D9%84%D9%85%D9%84%D9%84%DB%8C/",
            "https://kiusk.ca/blog/1400/12/7/set-up-a-car-repair-shop-in-canada",
            "https://kiusk.ca/blog/1400/04/12/%D8%B2%DB%8C%D8%A8%D8%A7%D8%AA%D8%B1%DB%8C%D9%86-%DA%A9%D9%88%D9%87-%D9%87%D8%A7%DB%8C-%DA%A9%D8%A7%D9%86%D8%A7%D8%AF%D8%A7-%DA%A9%D9%87-%D8%AD%DB%8C%D8%B1%D8%AA-%D8%A7%D9%86%DA%AF%DB%8C%D8%B2%D9%86/",
            "https://kiusk.ca/blog/1400/05/08/radiology-is-a-popular-field-in-canada/",
            "https://kiusk.ca/product-category/%D8%AE%D8%AF%D9%85%D8%A7%D8%AA-%D9%85%D8%B3%D8%A7%D9%81%D8%B1%D8%AA%DB%8C-%D9%88-%D8%A7%D9%82%D8%A7%D9%85%D8%AA/",
            "https://kiusk.ca/blog/1400/04/30/the-most-beautiful-canadian-libraries-in-the-world/",
            "https://kiusk.ca/blog/2021/08/29/the-taliban-sealed-kabul-airport/",
            "https://kiusk.ca/blog/1400/07/25/a-72-year-old-man-in-alberta-has-been-charged-with-murder/",
            "https://kiusk.ca/blog/1400/06/02/the-owner-of-a-restaurant-called-for-an-end-to-the-anti-vaccine-protests/",
            "https://kiusk.ca/product-category/immigration-lawyer",
            "https://kiusk.ca/blog/1400/04/16/federal-government-measures-to-build-a-dedicated-express-train-route/",
            "https://kiusk.ca/blog/1400/12/8/launching-an-accounting-company",
            "https://kiusk.ca/blog/1400/07/13/the-federal-government-can-enforce-the-staff-corona-vaccination-law-in-the-provinces/",
            "https://kiusk.ca/product-category/cars/",
            "https://kiusk.ca/blog/1400/06/08/opposition-to-compulsory-vaccination-in-canada/",
            "https://kiusk.ca/blog/1400/06/09/the-liberals-commitment-to-allocating-billions-of-dollars-to-the-mental-health-of-indigenous-peoples/",
            "https://kiusk.ca/blog/1400/06/12/implementation-of-vaccination-requirements-from-friday-in-manitoba/",
            "https://kiusk.ca/blog/1400/04/21/what-do-you-know-about-the-graphic-industry-job-market-in-canada/",
            "https://kiusk.ca/blog/2022/02/09/fingerprinting-of-the-canadian-embassy/",
            "https://kiusk.ca/blog/1400/06/08/canada-talks-with-taliban-to-repatriate-canadian-citizens-to-afghanistan/",
            "https://kiusk.ca/blog/1400/08/08/allegedly-raped-by-prince-andrew/",
            "https://kiusk.ca/product-category/barbers-and-beauty-salons/",
            "https://kiusk.ca/blog/1400/07/17/school-reopens-in-ottawa-after-corona-outbreak/",
            "https://kiusk.ca/product-category/%D8%B9%DA%A9%D8%A7%D8%B3%DB%8C-%D9%88-%D9%81%DB%8C%D9%84%D9%85-%D8%A8%D8%B1%D8%AF%D8%A7%D8%B1%DB%8C/",
            "https://kiusk.ca/blog/1400/06/17/rent-a-house-in-the-big-city-of-toronto/",
            "https://kiusk.ca/blog/2022/01/29/kindergarten-set-up-in-canada/",
            "https://kiusk.ca/blog/1400/07/04/new-brunswicks-troubles-with-the-implementation-of-the-new-corona-restriction/",
            "https://kiusk.ca/blog/2022/02/20/launching-a-music-school/",
            "https://kiusk.ca/blog/1400/06/14/the-covid-19-vaccine-is-not-dangerous-for-people-with-allergies/",
            "https://kiusk.ca/blog/1400/05/31/all-about-life-insurance-in-canada-types-of-insurance-in-canada/",
            "https://kiusk.ca/blog/1400/08/01/high-paying-jobs-in-canada-without-a-bachelors-degree/",
            "https://kiusk.ca/blog/2021/08/02/chinese-canadian-pop-star-arrested-for-rape/",
            "https://kiusk.ca/blog/1400/04/13/arrest-of-a-man-and-woman-after-a-chase-on-a-busy-halifax-street/",
            "https://kiusk.ca/blog/1400/08/06/mandatory-vaccination-orders-in-new-york-and-staff-shortages/",
            "https://kiusk.ca/blog/1400/07/02/novoskusha-compulsory-vaccination-for-medical-staff/",

        ];

        DB::beginTransaction();

        foreach($oldLinks as $oldLink){
            $urlContent = Str::after($oldLink, 'https://kiusk.ca');
            $type = Str::before(Str::after($oldLink, 'https://kiusk.ca/'), '/');
            if($type == "blog"){
                $slug = Str::afterLast(rtrim($urlContent, '/'), '/');
                $post = Post::where('old_slug', $slug)->orWhere('slug', $slug)->first();
                if($post){
                    Redirect::updateOrCreate(
                        [
                            'from' => env('local') ? Str::replace('https://kiusk.ca', 'localhost', $oldLink) : $oldLink
                        ],
                        [
                            'to' => route('front.blog.show', $post->slug),
                            'new_slug' => $post->slug,
                            'old_slug' => $slug
                        ]
                    );
                }else{
                    dump($oldLink);
                }
            }elseif($type == 'ads'){
                $slug = Str::afterLast(rtrim($urlContent, '/'), '/');
                $ad = Ad::where('old_slug', $slug)->orWhere('slug', $slug)->first();
                if($ad){
                    Redirect::updateOrCreate(
                        [
                            'from' => env('local') ? Str::replace('https://kiusk.ca', 'localhost', $oldLink) : $oldLink
                        ],
                        [
                            'to' => route('front.ad.show', $ad->slug),
                            'new_slug' => $ad->slug,
                            'old_slug' => $slug
                        ]
                    );
                }else{
                    dump($oldLink);
                }

            }elseif($type == 'product-category'){
                $slug = Str::afterLast(rtrim($urlContent, '/'), '/');
                $category = Category::where('old_slug', $slug)->orWhere('slug', $slug)->first();
                if($category){
                    Redirect::updateOrCreate(
                        [
                            'from' => env('local') ? Str::replace('https://kiusk.ca', 'localhost', $oldLink) : $oldLink
                        ],
                        [
                            'to' => route('front.ad.category.index.first.page', $category->slug),
                            'new_slug' => $category->slug,
                            'old_slug' => $slug
                        ]
                    );
                }else{
                    dump($oldLink);
                }
            }else{
                dump($oldLink);
            }
            // dump(Str::between(Str::after($oldLink, 'https://kiusk.ca/'), '/', '/'));
        }



        // $ads = Ad::whereNotNull('old_slug')->get();
        // $categories = Category::whereNotNull('old_slug')->get();
        // $posts = Post::all();

        // foreach($ads as $ad){
        //     Redirect::updateOrCreate(
        //         [
        //             'new_slug' => $ad->slug,
        //         ],
        //         [
        //             'from' => route('front.ad.show', $ad->old_slug),
        //             'to' => route('front.ad.show', $ad->slug),
        //             'old_slug' => $ad->old_slug
        //         ]
        //     );
        // }
        // foreach($categories as $category){
        //     Redirect::updateOrCreate(
        //         [
        //             'new_slug' => $category->slug,
        //         ],
        //         [
        //             'from' => route('front.ad.category.index.first.page', $ad->old_slug),
        //             'to' => route('front.ad.category.index.first.page', $category->slug),
        //             'old_slug' => $category->old_slug
        //         ]
        //     );
        // }
        // foreach($posts as $post){
        //     if(($post->old_slug ?? $post->slug) != null){
        //         // dump($post->old_link);
        //         Redirect::updateOrCreate(
        //             [
        //                 'new_slug' => $post->slug,
        //             ],
        //             [
        //                 'from' => $post->old_link,
        //                 'to' => route('front.blog.show', $post->slug),
        //                 'old_slug' => $post->old_slug ?? $post->slug
        //             ]
        //         );
        //     }
        // }

        DB::commit();

        dd("done");
    }
}
