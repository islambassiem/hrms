export type QualificationLookup = {
    id: number;
    name: string;
};

export type EmployeeQualification = {
    id: number;
    employee_code: number;
    major: QualificationLookup | null;
    minor: QualificationLookup | null;
    educational_sublevel: QualificationLookup | null;
    included_specialty: QualificationLookup | null;
    institution_name: string | null;
    college_name: string | null;
    scientific_degree: QualificationLookup | null;
    graduation_date: string | null;
    graduation_country: QualificationLookup | null;
    is_last_qualification: boolean;
    rating: QualificationLookup | null;
    gpa: string | null;
    gpa_type: QualificationLookup | null;
    study_type: QualificationLookup | null;
    city: string | null;
    is_authenticated: boolean;
    created_by: QualificationLookup | null;
    updated_by: QualificationLookup | null;
};

export type EmployeeQualificationCollection = {
    data: EmployeeQualification[];
};

export type EmployeeQualificationIndexPageProps = {
    qualifications: EmployeeQualificationCollection;
    canCreate: boolean;
};

export type QualificationFormOptions = {
    countries: QualificationLookup[];
    educational_sublevels: QualificationLookup[];
    gpa_types: QualificationLookup[];
    included_specializations: QualificationLookup[];
    ratings: QualificationLookup[];
    scientific_degrees: QualificationLookup[];
    specialities: QualificationLookup[];
    study_types: QualificationLookup[];
};

export type QualificationFormData = {
    major_id: number | null;
    minor_id: number | null;
    educational_sublevel_id: number | null;
    included_specialty_id: number | null;
    institution_name: string;
    college_name: string;
    scientific_degree_id: number | null;
    graduation_date: string;
    graduation_country_id: number | null;
    is_last_qualification: boolean;
    rating_id: number | null;
    gpa: string;
    gpa_type_id: number | null;
    study_type_id: number | null;
    city: string;
};

export type EmployeeQualificationCreatePageProps = {
    props: QualificationFormOptions;
};

export type EmployeeQualificationEditPageProps = {
    qualification: EmployeeQualification;
    props: QualificationFormOptions;
};

export type EmployeeQualificationShowPageProps = {
    qualification: EmployeeQualification;
};
